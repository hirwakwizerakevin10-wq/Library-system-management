@extends('layouts.app')
@section('title', $book->title)
@section('page-title', 'Book Details')
@section('content')
<div class="mb-4">
    <a href="{{ route('books.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-600 transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 19l-7-7 7-7"/></svg>
        Back to catalog
    </a>
</div>
@php
    $isAdmin = auth()->user()->isAdministrator();
@endphp
<div class="grid gap-6 lg:grid-cols-[.8fr_1.2fr]">
    <aside class="surface p-6">
        <div class="mb-5 grid h-14 w-14 place-items-center rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-200">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M20 22V6H6.5A2.5 2.5 0 0 0 4 8.5v11"/></svg>
        </div>
        <h2 class="text-2xl font-semibold tracking-tight">{{ $book->title }}</h2>
        <p class="mt-2 text-slate-500 dark:text-slate-400">{{ $book->author }}</p>
        <div class="mt-6 grid gap-3 sm:grid-cols-2">
            <div class="metric"><div class="text-sm text-slate-500">Category</div><div class="mt-1 font-semibold">{{ $book->category->name }}</div></div>
            @if($isAdmin)
                <div class="metric"><div class="text-sm text-slate-500">ISBN</div><div class="mt-1 font-mono text-sm">{{ $book->isbn }}</div></div>
            @endif
            <div class="metric"><div class="text-sm text-slate-500">Available</div><div class="mt-1 font-semibold">{{ $book->available_copies }} / {{ $book->quantity }}</div></div>
            @if($isAdmin)
                <div class="metric"><div class="text-sm text-slate-500">Shelf</div><div class="mt-1 font-semibold">{{ $book->shelf_location ?: 'Not assigned' }}</div></div>
            @endif
        </div>
        <div class="mt-6 flex gap-2">
            @if($isAdmin)
                <a href="{{ route('books.edit', $book) }}" class="btn btn-primary">Edit Book</a>
            @elseif($book->available_copies > 0)
                <a href="{{ route('borrows.create', ['book_id' => $book->id]) }}" class="btn btn-primary">Request Book</a>
            @endif
        </div>
    </aside>

    @if($isAdmin)
    <section class="surface">
        <div class="card-header">
            <h2 class="text-lg font-semibold tracking-tight">Borrow History</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Every checkout, return, and loss linked to this book.</p>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>Customer</th><th>Borrowed</th><th>Due</th><th>Returned</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse ($book->borrows as $borrow)
                        <tr>
                            <td>{{ $borrow->student->full_name }}</td>
                            <td>{{ $borrow->borrow_date->format('M d, Y') }}</td>
                            <td>{{ $borrow->due_date->format('M d, Y') }}</td>
                            <td>{{ $borrow->return_date?->format('M d, Y') ?? 'Pending' }}</td>
                            <td><span class="badge text-bg-{{ $borrow->status === 'borrowed' ? 'warning' : ($borrow->status === 'lost' ? 'danger' : 'success') }}">{{ ucfirst($borrow->status) }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><div class="empty-state">No borrowing history yet.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
    @else
    <section class="surface p-6">
        <h2 class="text-lg font-semibold tracking-tight">Customer Access</h2>
        <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">Only catalog information and availability are shown here. Borrowing history is private to each customer account.</p>
    </section>
    @endif
</div>
@endsection
