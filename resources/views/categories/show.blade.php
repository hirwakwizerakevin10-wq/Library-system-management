@extends('layouts.app')
@section('title', 'Category Details')
@section('page-title', 'Category Details')
@section('content')
<div class="mb-4">
    <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-600 transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 19l-7-7 7-7"/></svg>
        Back to categories
    </a>
</div>
<div class="surface p-6">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight">{{ $category->name }}</h2>
            <p class="mt-1 text-slate-500 dark:text-slate-400">{{ $category->description ?: 'No description provided.' }}</p>
        </div>
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-primary">Edit Category</a>
    </div>
    <div class="mt-6">
        <h3 class="text-lg font-semibold">Books in this Category ({{ $category->books->count() }})</h3>
        <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($category->books as $book)
                <a href="{{ route('books.show', $book) }}" class="block rounded-lg border border-slate-200 bg-slate-50 p-4 transition hover:-translate-y-0.5 hover:bg-white dark:border-slate-800 dark:bg-slate-950/40 dark:hover:bg-slate-900">
                    <div class="text-sm font-semibold text-slate-950 dark:text-white">{{ $book->title }}</div>
                    <div class="mt-1 text-xs text-slate-500">{{ $book->author }}</div>
                    <div class="mt-2 flex items-center justify-between">
                        <span class="text-xs text-slate-500">ISBN: {{ $book->isbn }}</span>
                        <span class="text-xs font-semibold {{ $book->available_copies > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">{{ $book->available_copies }}/{{ $book->quantity }}</span>
                    </div>
                </a>
            @empty
                <div class="empty-state sm:col-span-2 lg:col-span-3">No books in this category yet.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
