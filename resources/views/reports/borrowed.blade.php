@extends('layouts.app')
@section('title', 'Borrowed Books Report')
@section('page-title', 'Borrowed Books Report')
@section('content')
@php
    $overdueCount = $borrows->filter(fn($b) => $b->due_date->isPast())->count();
@endphp
<div class="mb-6 grid gap-4 sm:grid-cols-2">
    <div class="metric"><div class="text-2xl font-bold">{{ $borrows->total() }}</div><div class="text-sm text-slate-500">Total borrowed</div></div>
    <div class="metric"><div class="text-2xl font-bold text-rose-600 dark:text-rose-400">{{ $overdueCount }}</div><div class="text-sm text-slate-500">Overdue</div></div>
</div>
<div class="card table-card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Book</th><th>Customer</th><th>Borrowed</th><th>Due Date</th><th>Overdue</th></tr></thead>
            <tbody>
            @forelse($borrows as $borrow)
                <tr>
                    <td class="font-semibold">{{ $borrow->book->title }}</td>
                    <td>{{ $borrow->student->full_name }}</td>
                    <td>{{ $borrow->borrow_date->format('M d, Y') }}</td>
                    <td>{{ $borrow->due_date->format('M d, Y') }}</td>
                    <td>
                        @if($borrow->due_date->isPast())
                            <span class="badge text-bg-danger">Yes</span>
                        @else
                            <span class="badge text-bg-success">No</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No active borrowed books.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $borrows->links() }}</div>
</div>
@endsection
