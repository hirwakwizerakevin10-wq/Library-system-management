<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\LostBook;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    public function index(Request $request)
    {
        $student = $request->user()->student;

        $borrows = Borrow::with(['book', 'student'])
            ->when($request->user()->isCustomer(), fn ($query) => $query->where('student_id', $student?->id))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('book', fn ($query) => $query->where('title', 'like', "%{$search}%"))
                        ->orWhereHas('student', fn ($query) => $query->where('full_name', 'like', "%{$search}%")
                            ->orWhere('registration_number', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('borrows.index', compact('borrows'));
    }

    public function create()
    {
        if (request()->user()->isCustomer()) {
            return view('borrows.create', [
                'books' => Book::where('available_copies', '>', 0)->orderBy('title')->get(),
                'students' => collect(),
            ]);
        }

        return view('borrows.create', [
            'books' => Book::where('available_copies', '>', 0)->orderBy('title')->get(),
            'students' => Student::orderBy('full_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'book_id' => ['required', 'exists:books,id'],
            'notes' => ['nullable', 'string'],
        ];

        if ($request->user()->isAdministrator()) {
            $rules += [
                'student_id' => ['required', 'exists:students,id'],
                'borrow_date' => ['required', 'date'],
                'due_date' => ['required', 'date', 'after_or_equal:borrow_date'],
            ];
        }

        $data = $request->validate($rules);

        if ($request->user()->isCustomer()) {
            $student = $request->user()->student;

            if (! $student) {
                return back()
                    ->withInput()
                    ->with('error', 'Your customer profile is missing. Please contact an administrator.');
            }

            $data += [
                'student_id' => $student->id,
                'borrow_date' => now()->toDateString(),
                'due_date' => now()->addDays(14)->toDateString(),
                'status' => 'pending',
            ];

            Borrow::create($data);

            return redirect()->route('borrows.index')->with('success', 'Borrow request submitted. An administrator will review it.');
        }

        $borrowed = DB::transaction(function () use ($data) {
            $book = Book::lockForUpdate()->findOrFail($data['book_id']);

            if ($book->available_copies < 1) {
                return false;
            }

            Borrow::create($data + ['status' => 'borrowed']);
            $book->decrement('available_copies');
            $book->refresh()->update(['status' => $book->available_copies > 0 ? 'available' : 'borrowed']);
            return true;
        });

        if (! $borrowed) {
            return back()
                ->withInput()
                ->with('error', 'This book is not available for borrowing.');
        }

        return redirect()->route('borrows.index')->with('success', 'Book borrowed successfully.');
    }

    public function show(Borrow $borrow)
    {
        $this->authorizeBorrowAccess($borrow);

        $borrow->load(['book.category', 'student', 'lostBook']);

        return view('borrows.show', compact('borrow'));
    }

    public function edit(Borrow $borrow)
    {
        return redirect()->route('borrows.show', $borrow);
    }

    public function update(Request $request, Borrow $borrow)
    {
        return redirect()->route('borrows.show', $borrow);
    }

    public function destroy(Borrow $borrow)
    {
        return back()->with('error', 'Borrow history is preserved for audit reporting.');
    }

    public function returnBook(Borrow $borrow)
    {
        if ($borrow->status !== 'borrowed') {
            return back()->with('error', 'Only active borrowings can be returned.');
        }

        DB::transaction(function () use ($borrow) {
            $borrow = Borrow::lockForUpdate()->findOrFail($borrow->id);
            if ($borrow->status !== 'borrowed') {
                return false;
            }
            $book = Book::lockForUpdate()->findOrFail($borrow->book_id);
            $borrow->update(['status' => 'returned', 'return_date' => now()->toDateString()]);
            $book->increment('available_copies');
            $book->refresh()->update(['status' => 'available']);
            return true;
        });

        return redirect()->route('borrows.index')->with('success', 'Book returned and inventory updated.');
    }

    public function approve(Borrow $borrow)
    {
        if ($borrow->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be approved.');
        }

        $approved = DB::transaction(function () use ($borrow) {
            $book = Book::lockForUpdate()->findOrFail($borrow->book_id);

            if ($book->available_copies < 1) {
                return false;
            }

            $borrow->update([
                'status' => 'borrowed',
                'borrow_date' => now()->toDateString(),
                'due_date' => now()->addDays(14)->toDateString(),
            ]);

            $book->decrement('available_copies');
            $book->refresh()->update(['status' => $book->available_copies > 0 ? 'available' : 'borrowed']);
            return true;
        });

        if (! $approved) {
            return back()->with('error', 'This book is no longer available.');
        }

        return redirect()->route('borrows.index')->with('success', 'Borrow request approved and inventory updated.');
    }

    public function reject(Request $request, Borrow $borrow)
    {
        if ($borrow->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be rejected.');
        }

        $data = $request->validate([
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $borrow->update([
            'status' => 'rejected',
            'notes' => $data['notes'] ?? $borrow->notes,
        ]);

        return redirect()->route('borrows.index')->with('success', 'Borrow request rejected.');
    }

    public function lost(Request $request, Borrow $borrow)
    {
        if ($borrow->status !== 'borrowed') {
            return back()->with('error', 'Only active borrowings can be marked as lost.');
        }

        $data = $request->validate(['notes' => ['nullable', 'string']]);

        DB::transaction(function () use ($borrow, $data) {
            LostBook::create([
                'book_id' => $borrow->book_id,
                'student_id' => $borrow->student_id,
                'borrow_id' => $borrow->id,
                'quantity' => 1,
                'lost_date' => now()->toDateString(),
                'notes' => $data['notes'] ?? 'Marked lost from active borrowing.',
            ]);

            $borrow->update(['status' => 'lost']);
        });

        return redirect()->route('lost-books.index')->with('success', 'Lost book recorded. Inventory remains reduced.');
    }

    private function authorizeBorrowAccess(Borrow $borrow): void
    {
        $user = request()->user();

        if ($user->isAdministrator()) {
            return;
        }

        abort_unless($user->student && $borrow->student_id === $user->student->id, 403);
    }
}
