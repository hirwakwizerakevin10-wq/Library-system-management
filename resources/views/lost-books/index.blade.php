@extends('layouts.app')
@section('title', 'Lost Books')
@section('page-title', 'Lost Books')
@section('content')
<div class="card table-card">
    <div class="card-header flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
        <form class="grid gap-2 sm:grid-cols-[1fr_auto_auto]" method="GET">
            <input name="search" placeholder="Search lost records" value="{{ request('search') }}">
            @if(request('search'))<a href="{{ route('lost-books.index') }}" class="btn btn-outline-secondary">Clear</a>@endif
            <button class="btn btn-outline-primary">Search</button>
        </form>
        <a class="btn btn-danger" href="{{ route('lost-books.create') }}">Record Lost Book</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Book</th><th>Responsible Customer</th><th>Quantity</th><th>Lost Date</th><th>Notes</th><th class="text-end">View</th></tr></thead>
            <tbody>
            @forelse($lostBooks as $lost)
                <tr>
                    <td class="font-semibold">{{ $lost->book->title }}</td>
                    <td>{{ $lost->student->full_name }}</td>
                    <td>{{ $lost->quantity }}</td>
                    <td>{{ $lost->lost_date->format('M d, Y') }}</td>
                    <td class="max-w-md">{{ $lost->notes ?: 'No notes' }}</td>
                    <td class="text-end"><a class="action-icon" href="{{ route('lost-books.show', $lost) }}" title="View lost record"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/></svg></a></td>
                </tr>
            @empty
                <tr><td colspan="6"><div class="empty-state">No lost books recorded.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $lostBooks->links() }}</div>
</div>
@endsection
