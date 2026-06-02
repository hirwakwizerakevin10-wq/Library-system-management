@extends('layouts.app')
@section('title', auth()->user()->isAdministrator() ? 'Books' : 'Available Books')
@section('page-title', auth()->user()->isAdministrator() ? 'Catalog & Inventory' : 'Available Books')
@section('content')
@php
    $isAdmin = auth()->user()->isAdministrator();
@endphp
<div class="mb-5 grid gap-4 md:grid-cols-3">
    <div class="metric"><div class="text-2xl font-bold">{{ $books->total() }}</div><div class="text-sm text-slate-500">Books matching search</div></div>
    <div class="metric"><div class="text-2xl font-bold">{{ $books->sum('available_copies') }}</div><div class="text-sm text-slate-500">Available on this page</div></div>
    <div class="metric"><div class="text-2xl font-bold">{{ $books->where('available_copies', 0)->count() }}</div><div class="text-sm text-slate-500">Unavailable on this page</div></div>
</div>

<div class="card table-card">
    <div class="card-header flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
        <form class="grid gap-2 sm:grid-cols-[1fr_auto_auto]" method="GET">
            <input name="search" placeholder="{{ $isAdmin ? 'Search title, author, ISBN, or shelf' : 'Search title or author' }}" value="{{ request('search') }}" aria-label="Search books">
            @if(request('search'))
                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Clear</a>
            @endif
            <button class="btn btn-outline-primary">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m21 21-4.3-4.3M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16Z"/></svg>
                Search
            </button>
        </form>
        @if($isAdmin)
            <a href="{{ route('books.create') }}" class="btn btn-primary">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Add Book
            </a>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Book</th><th>Category</th>@if($isAdmin)<th>ISBN</th>@endif<th>Copies available</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($books as $book)
                <tr>
                    <td>
                        <div class="font-semibold text-slate-950 dark:text-white">{{ $book->title }}</div>
                        <div class="mt-1 text-xs text-slate-500">{{ $book->author }}@if($isAdmin) &middot; {{ $book->shelf_location ?: 'No shelf assigned' }}@endif</div>
                    </td>
                    <td>{{ $book->category->name }}</td>
                    @if($isAdmin)<td><span class="font-mono text-xs">{{ $book->isbn }}</span></td>@endif
                    <td>
                        <div class="font-semibold">{{ $book->available_copies }} / {{ $book->quantity }}</div>
                        <div class="mt-2 h-1.5 w-24 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-800">
                            <div class="h-full rounded-full bg-emerald-500" style="width: {{ max(0, min(100, ($book->available_copies / max(1, $book->quantity)) * 100)) }}%"></div>
                        </div>
                    </td>
                    <td><span class="badge text-bg-{{ $book->available_copies > 0 ? 'success' : 'warning' }}">{{ ucfirst($book->status) }}</span></td>
                    <td>
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('books.show', $book) }}" class="action-icon" title="View book">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/></svg>
                            </a>
                            @if($isAdmin)
                                <a href="{{ route('books.edit', $book) }}" class="action-icon" title="Edit book">
                                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('books.destroy', $book) }}" onsubmit="return confirm('Delete this book?')">
                                    @csrf @method('DELETE')
                                    <button class="action-icon action-icon-danger" title="Delete book">
                                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('borrows.create', ['book_id' => $book->id]) }}" class="btn btn-sm btn-outline-primary">Request</a>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $isAdmin ? 6 : 5 }}">
                        <div class="empty-state">
                            <div class="empty-icon"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/></svg></div>
                            <div class="font-semibold text-slate-700 dark:text-slate-200">No books found</div>
                            <p class="mt-1 text-sm">Add your first title or adjust the search terms.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $books->links() }}</div>
</div>
@endsection
