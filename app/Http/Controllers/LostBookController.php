<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\LostBook;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LostBookController extends Controller
{
    public function index(Request $request)
    {
        $lostBooks = LostBook::with(['book', 'student'])
            ->when($request->search, function ($query, $search) {
                $query->whereHas('book', fn ($query) => $query->where('title', 'like', "%{$search}%"))
                    ->orWhereHas('student', fn ($query) => $query->where('full_name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('lost-books.index', compact('lostBooks'));
    }

    public function create()
    {
        return view('lost-books.create', [
            'books' => Book::orderBy('title')->get(),
            'students' => Student::orderBy('full_name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id' => ['required', 'exists:books,id'],
            'student_id' => ['required', 'exists:students,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'lost_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $recorded = DB::transaction(function () use ($data) {
            $book = Book::lockForUpdate()->findOrFail($data['book_id']);

            if ($book->available_copies < $data['quantity']) {
                return false;
            }

            LostBook::create($data);
            $book->decrement('available_copies', $data['quantity']);
            $book->refresh()->update(['status' => $book->available_copies > 0 ? 'available' : 'borrowed']);
            return true;
        });

        if (! $recorded) {
            return back()
                ->withInput()
                ->with('error', 'Lost quantity cannot exceed available copies for standalone records.');
        }

        return redirect()->route('lost-books.index')->with('success', 'Lost book recorded and inventory updated.');
    }

    public function show(LostBook $lostBook)
    {
        $lostBook->load(['book', 'student', 'borrow']);

        return view('lost-books.show', compact('lostBook'));
    }
}
