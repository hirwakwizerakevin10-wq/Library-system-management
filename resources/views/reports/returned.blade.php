@extends('layouts.app')
@section('title', 'Returned Books Report')
@section('page-title', 'Returned Books Report')
@section('content')
<div class="card table-card"><div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Book</th><th>Customer</th><th>Borrowed</th><th>Returned</th></tr></thead><tbody>@forelse($borrows as $borrow)<tr><td>{{ $borrow->book->title }}</td><td>{{ $borrow->student->full_name }}</td><td>{{ $borrow->borrow_date->format('M d, Y') }}</td><td>{{ $borrow->return_date?->format('M d, Y') }}</td></tr>@empty<tr><td colspan="4" class="text-center text-muted py-4">No returned books yet.</td></tr>@endforelse</tbody></table></div><div class="card-footer bg-white">{{ $borrows->links() }}</div></div>
@endsection
