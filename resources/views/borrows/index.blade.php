@extends('layouts.app')
@section('title', auth()->user()->isAdministrator() ? 'Borrowing History' : 'My Borrowing')
@section('page-title', auth()->user()->isAdministrator() ? 'Borrowing & Returns' : 'My Borrowing Records')
@section('content')
@php
    $isAdmin = auth()->user()->isAdministrator();
@endphp
<div class="card table-card">
    <div class="card-header flex flex-col gap-3 xl:flex-row xl:items-center xl:justify-between">
        <form class="grid gap-2 sm:grid-cols-[1fr_12rem_auto_auto]" method="GET">
            <input name="search" placeholder="Search book, customer, or registration number" value="{{ request('search') }}" aria-label="Search borrowing records">
            <select name="status" aria-label="Filter status">
                <option value="">All statuses</option>
                @foreach(['pending','borrowed','returned','rejected','lost'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            @if(request('search') || request('status'))
                <a href="{{ route('borrows.index') }}" class="btn btn-outline-secondary">Clear</a>
            @endif
            <button class="btn btn-outline-primary">Filter</button>
        </form>
        <a href="{{ route('borrows.create') }}" class="btn btn-primary">
            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            {{ $isAdmin ? 'Borrow Book' : 'Request Book' }}
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr>@if($isAdmin)<th>Customer</th>@endif<th>Book</th><th>Borrowed</th><th>Due</th><th>Returned</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse($borrows as $borrow)
                @php
                    $isOverdue = $borrow->status === 'borrowed' && $borrow->due_date->isPast();
                    $statusTone = $borrow->status === 'pending' ? 'info' : ($borrow->status === 'borrowed' ? ($isOverdue ? 'danger' : 'warning') : (in_array($borrow->status, ['rejected', 'lost'], true) ? 'danger' : 'success'));
                @endphp
                <tr>
                    @if($isAdmin)<td><div class="font-semibold">{{ $borrow->student->full_name }}</div><div class="text-xs text-slate-500">{{ $borrow->student->registration_number }}</div></td>@endif
                    <td>{{ $borrow->book->title }}</td>
                    <td>{{ $borrow->borrow_date->format('M d, Y') }}</td>
                    <td><span class="{{ $isOverdue ? 'font-semibold text-rose-600 dark:text-rose-300' : '' }}">{{ $borrow->due_date->format('M d, Y') }}</span></td>
                    <td>{{ $borrow->return_date?->format('M d, Y') ?? 'Pending' }}</td>
                    <td>
                        <span class="badge text-bg-{{ $statusTone }}">
                            {{ $isOverdue ? 'Overdue' : ucfirst($borrow->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="flex flex-wrap justify-end gap-2">
                            <a href="{{ route('borrows.show', $borrow) }}" class="action-icon" title="View record">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/></svg>
                            </a>
                            @if($isAdmin && $borrow->status === 'pending')
                                <form method="POST" action="{{ route('borrows.approve', $borrow) }}">@csrf<button class="btn btn-sm btn-outline-success">Approve</button></form>
                                <form method="POST" action="{{ route('borrows.reject', $borrow) }}" onsubmit="return confirm('Reject this borrow request?')">@csrf<button class="btn btn-sm btn-outline-danger">Reject</button></form>
                            @endif
                            @if($isAdmin && $borrow->status === 'borrowed')
                                <form method="POST" action="{{ route('borrows.return', $borrow) }}">@csrf<button class="btn btn-sm btn-outline-success">Return</button></form>
                                <form method="POST" action="{{ route('borrows.lost', $borrow) }}" onsubmit="return confirm('Mark this borrowed book as lost?')">@csrf<button class="btn btn-sm btn-outline-danger">Lost</button></form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="{{ $isAdmin ? 7 : 6 }}"><div class="empty-state"><div class="empty-icon">0</div><div class="font-semibold">No borrowing records found</div><p class="mt-1 text-sm">{{ $isAdmin ? 'Create a borrowing record when a customer checks out a book.' : 'Request a book to start your borrowing history.' }}</p></div></td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $borrows->links() }}</div>
</div>
@endsection
