<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with('category')
            ->when($request->user()?->isCustomer(), fn ($query) => $query->where('available_copies', '>', 0))
            ->when($request->search, function ($query, $search) {
                if (request()->user()?->isCustomer()) {
                    $query->where(function ($query) use ($search) {
                        $query->where('title', 'like', "%{$search}%")
                            ->orWhere('author', 'like', "%{$search}%");
                    });

                    return;
                }

                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%")
                        ->orWhere('shelf_location', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create', [
            'book' => null,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['available_copies'] = min($data['available_copies'], $data['quantity']);
        $data['status'] = $this->bookStatus($data['available_copies'], $data['quantity']);

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }

    public function show(Book $book)
    {
        if (request()->user()?->isCustomer() && $book->available_copies < 1) {
            abort(404);
        }

        $book->load(['category', 'borrows.student']);

        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', ['book' => $book, 'categories' => Category::orderBy('name')->get()]);
    }

    public function update(Request $request, Book $book)
    {
        $data = $this->validated($request, $book->id);
        $borrowed = $book->borrows()->where('status', 'borrowed')->count();

        if ($data['quantity'] < $borrowed) {
            return back()->withInput()->with('error', 'Quantity cannot be lower than active borrowed copies.');
        }

        $data['available_copies'] = min($data['available_copies'], $data['quantity'] - $borrowed);
        $data['status'] = $this->bookStatus($data['available_copies'], $data['quantity']);
        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        if ($book->borrows()->whereIn('status', ['borrowed', 'pending'])->exists()) {
            return back()->with('error', 'Return or mark active borrowings before deleting this book.');
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:100', 'unique:books,isbn,'.$id],
            'quantity' => ['required', 'integer', 'min:0'],
            'available_copies' => ['required', 'integer', 'min:0'],
            'shelf_location' => ['nullable', 'string', 'max:255'],
        ]);
    }

    private function bookStatus(int $available, int $quantity): string
    {
        if ($quantity === 0) {
            return 'unavailable';
        }

        return $available > 0 ? 'available' : 'borrowed';
    }
}
