@extends('layouts.app')
@section('title', 'Lost Books Report')
@section('page-title', 'Lost Books Report')
@section('content')
<div class="card table-card"><div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Book</th><th>Customer</th><th>Qty</th><th>Lost Date</th><th>Notes</th></tr></thead><tbody>@forelse($lostBooks as $lost)<tr><td>{{ $lost->book->title }}</td><td>{{ $lost->student->full_name }}</td><td>{{ $lost->quantity }}</td><td>{{ $lost->lost_date->format('M d, Y') }}</td><td>{{ $lost->notes }}</td></tr>@empty<tr><td colspan="5" class="text-center text-muted py-4">No lost books recorded.</td></tr>@endforelse</tbody></table></div><div class="card-footer bg-white">{{ $lostBooks->links() }}</div></div>
@endsection
