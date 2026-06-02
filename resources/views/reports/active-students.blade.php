@extends('layouts.app')
@section('title', 'Customers With Active Borrowings')
@section('page-title', 'Customers With Active Borrowings')
@section('content')
<div class="card table-card"><div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Customer</th><th>Registration</th><th>Department/Class</th><th>Active Books</th></tr></thead><tbody>@forelse($students as $student)<tr><td>{{ $student->full_name }}</td><td>{{ $student->registration_number }}</td><td>{{ $student->department }}</td><td>@foreach($student->borrows as $borrow)<span class="badge badge-soft me-1">{{ $borrow->book->title }}</span>@endforeach</td></tr>@empty<tr><td colspan="4" class="text-center text-muted py-4">No customers have active borrowings.</td></tr>@endforelse</tbody></table></div><div class="card-footer bg-white">{{ $students->links() }}</div></div>
@endsection
