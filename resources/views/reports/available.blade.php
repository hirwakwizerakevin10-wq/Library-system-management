@extends('layouts.app')
@section('title', 'Available Books Report')
@section('page-title', 'Available Books Report')
@section('content')
@php
    $totalAvailable = $books->sum('available_copies');
@endphp
<div class="mb-6">
    <div class="metric inline-block"><div class="text-2xl font-bold">{{ $totalAvailable }}</div><div class="text-sm text-slate-500">Copies available across catalog</div></div>
</div>
<div class="card table-card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Title</th><th>Category</th><th>Author</th><th>ISBN</th><th>Available</th><th>Shelf</th></tr></thead>
            <tbody>
            @forelse($books as $book)
                <tr>
                    <td class="font-semibold">{{ $book->title }}</td>
                    <td><span class="badge badge-soft">{{ $book->category->name }}</span></td>
                    <td>{{ $book->author }}</td>
                    <td class="font-mono text-xs">{{ $book->isbn }}</td>
                    <td><span class="font-semibold {{ $book->available_copies > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">{{ $book->available_copies }}</span></td>
                    <td>{{ $book->shelf_location ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No available books.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $books->links() }}</div>
</div>
@endsection
