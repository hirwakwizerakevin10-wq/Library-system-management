@extends('layouts.app')
@section('title', 'Borrowed Books Report')
@section('page-title', 'Borrowed Books Report')
@section('content')
<div class="card table-card"><div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Book</th><th>Customer</th><th>Borrowed</th><th>Due Date</th><th>Overdue</th></tr></thead><tbody>@forelse($borrows as $borrow)<tr><td>{{ $borrow->book->title }}</td><td>{{ $borrow->student->full_name }}</td><td>{{ $borrow->borrow_date->format('M d, Y') }}</td><td>{{ $borrow->due_date->format('M d, Y') }}</td><td>@if($borrow->due_date->isPast())<span class="badge text-bg-danger">Yes</span>@else<span class="badge text-bg-success">No</span>@endif</td></tr>@empty<tr><td colspan="5" class="text-center text-muted py-4">No active borrowed books.</td></tr>@endforelse</tbody></table></div><div class="card-footer bg-white">{{ $borrows->links() }}</div></div>
@endsection
