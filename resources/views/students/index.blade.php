@extends('layouts.app')
@section('title', 'Customers')
@section('page-title', 'Customers & Members')
@section('content')
<div class="card table-card">
    <div class="card-header flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
        <form class="grid gap-2 sm:grid-cols-[1fr_auto_auto]" method="GET">
            <input name="search" placeholder="Search name, email, registration, or department" value="{{ request('search') }}">
            @if(request('search'))<a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Clear</a>@endif
            <button class="btn btn-outline-primary">Search</button>
        </form>
        <a href="{{ route('students.create') }}" class="btn btn-primary">Add Customer</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Customer</th><th>Contact</th><th>Department/Class</th><th>Active Borrows</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse($students as $student)
                <tr>
                    <td><div class="font-semibold">{{ $student->full_name }}</div><div class="text-xs text-slate-500">{{ $student->registration_number }}</div></td>
                    <td>{{ $student->email }}<div class="text-xs text-slate-500">{{ $student->phone ?: 'No phone' }}</div></td>
                    <td>{{ $student->department }}</td>
                    <td><span class="badge {{ $student->active_borrows_count ? 'text-bg-warning' : 'badge-soft' }}">{{ $student->active_borrows_count }}</span></td>
                    <td><div class="flex justify-end gap-2">
                        <a class="action-icon" href="{{ route('students.show', $student) }}" title="View customer"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/></svg></a>
                        <a class="action-icon" href="{{ route('students.edit', $student) }}" title="Edit customer"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg></a>
                        <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Delete this customer?')">@csrf @method('DELETE')<button class="action-icon action-icon-danger" title="Delete customer"><svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/></svg></button></form>
                    </div></td>
                </tr>
            @empty
                <tr><td colspan="5"><div class="empty-state">No customers found.</div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $students->links() }}</div>
</div>
@endsection
