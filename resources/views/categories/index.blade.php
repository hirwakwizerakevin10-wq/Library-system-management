@extends('layouts.app')
@section('title', 'Categories')
@section('page-title', 'Categories')
@section('content')
<div class="card table-card">
    <div class="card-header flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
        <form class="grid gap-2 sm:grid-cols-[1fr_auto_auto]" method="GET">
            <input name="search" placeholder="Search categories" value="{{ request('search') }}">
            @if(request('search'))<a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Clear</a>@endif
            <button class="btn btn-outline-primary">Search</button>
        </form>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Add Category</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Name</th><th>Description</th><th>Books</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td class="font-semibold">{{ $category->name }}</td>
                    <td class="max-w-xl">{{ $category->description ?: 'No description provided.' }}</td>
                    <td><span class="badge badge-soft">{{ $category->books_count }}</span></td>
                    <td><div class="flex justify-end gap-2">
                        <a class="action-icon" href="{{ route('categories.show', $category) }}" title="View category"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/></svg></a>
                        <a class="action-icon" href="{{ route('categories.edit', $category) }}" title="Edit category"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg></a>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">@csrf @method('DELETE')<button class="action-icon action-icon-danger" title="Delete category"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg></button></form>
                    </div></td>
                </tr>
            @empty
                <tr><td colspan="4"><div class="empty-state">No categories found.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $categories->links() }}</div>
</div>
@endsection
