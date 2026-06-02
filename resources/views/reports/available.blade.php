@extends('layouts.app')
@section('title', 'Available Books Report')
@section('page-title', 'Available Books Report')
@section('content')
<div class="card table-card"><div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Title</th><th>Category</th><th>Author</th><th>ISBN</th><th>Available</th><th>Shelf</th></tr></thead><tbody>@forelse($books as $book)<tr><td>{{ $book->title }}</td><td>{{ $book->category->name }}</td><td>{{ $book->author }}</td><td>{{ $book->isbn }}</td><td>{{ $book->available_copies }}</td><td>{{ $book->shelf_location }}</td></tr>@empty<tr><td colspan="6" class="text-center text-muted py-4">No available books.</td></tr>@endforelse</tbody></table></div><div class="card-footer bg-white">{{ $books->links() }}</div></div>
@endsection
