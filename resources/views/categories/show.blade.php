@extends('layouts.app')
@section('title', $category->name)
@section('page-title', 'Category Details')
@section('content')
<div class="surface">
    <div class="card-header flex flex-wrap items-start justify-between gap-3">
        <div>
            <h2 class="text-2xl font-semibold">{{ $category->name }}</h2>
            <p class="mt-2 max-w-3xl text-sm text-slate-500 dark:text-slate-400">{{ $category->description ?: 'No description provided.' }}</p>
        </div>
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">Edit Category</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Book</th><th>Author</th><th>Available</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($category->books as $book)
                <tr><td class="font-semibold">{{ $book->title }}</td><td>{{ $book->author }}</td><td>{{ $book->available_copies }} / {{ $book->quantity }}</td><td><span class="badge text-bg-{{ $book->available_copies > 0 ? 'success' : 'warning' }}">{{ ucfirst($book->status) }}</span></td></tr>
            @empty
                <tr><td colspan="4"><div class="empty-state">No books in this category.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
