@extends('layouts.app')
@section('title', 'Borrow Record')
@section('page-title', 'Borrow Record')
@section('content')
@php
    $isOverdue = $borrow->status === 'borrowed' && $borrow->due_date->isPast();
    $isAdmin = auth()->user()->isAdministrator();
    $statusTone = $borrow->status === 'pending' ? 'info' : ($borrow->status === 'borrowed' ? ($isOverdue ? 'danger' : 'warning') : (in_array($borrow->status, ['rejected', 'lost'], true) ? 'danger' : 'success'));
@endphp
<div class="mb-4">
    <a href="{{ route('borrows.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-600 transition hover:text-slate-900 dark:text-slate-400 dark:hover:text-white">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 19l-7-7 7-7"/></svg>
        Back to records
    </a>
</div>
<div class="surface p-6">
    <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
        <div>
            <span class="badge text-bg-{{ $statusTone }}">{{ $isOverdue ? 'Overdue' : ucfirst($borrow->status) }}</span>
            <h2 class="mt-3 text-2xl font-semibold tracking-tight">{{ $borrow->book->title }}</h2>
            <p class="mt-1 text-slate-500 dark:text-slate-400">{{ $borrow->book->author }} · {{ $borrow->book->isbn }}</p>
        </div>
        @if($isAdmin && $borrow->status === 'pending')
            <div class="flex gap-2">
                <form method="POST" action="{{ route('borrows.approve', $borrow) }}">@csrf<button class="btn btn-outline-success">Approve Request</button></form>
                <form method="POST" action="{{ route('borrows.reject', $borrow) }}" onsubmit="return confirm('Reject this borrow request?')">@csrf<button class="btn btn-outline-danger">Reject</button></form>
            </div>
        @endif
        @if($isAdmin && $borrow->status === 'borrowed')
            <div class="flex gap-2">
                <form method="POST" action="{{ route('borrows.return', $borrow) }}">@csrf<button class="btn btn-outline-success">Return Book</button></form>
                <form method="POST" action="{{ route('borrows.lost', $borrow) }}" onsubmit="return confirm('Mark this borrowed book as lost?')">@csrf<button class="btn btn-outline-danger">Mark Lost</button></form>
            </div>
        @endif
    </div>
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="metric"><div class="text-sm text-slate-500">Customer</div><div class="mt-1 font-semibold">{{ $borrow->student->full_name }}</div><div class="text-xs text-slate-500">{{ $borrow->student->registration_number }}</div></div>
        <div class="metric"><div class="text-sm text-slate-500">Borrowed</div><div class="mt-1 font-semibold">{{ $borrow->borrow_date->format('M d, Y') }}</div></div>
        <div class="metric"><div class="text-sm text-slate-500">Due</div><div class="mt-1 font-semibold {{ $isOverdue ? 'text-rose-600 dark:text-rose-300' : '' }}">{{ $borrow->due_date->format('M d, Y') }}</div></div>
        <div class="metric"><div class="text-sm text-slate-500">Returned</div><div class="mt-1 font-semibold">{{ $borrow->return_date?->format('M d, Y') ?? 'Pending' }}</div></div>
    </div>
    @if($borrow->notes)
        <div class="mt-6 rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm dark:border-slate-800 dark:bg-slate-950/40">{{ $borrow->notes }}</div>
    @endif
</div>
@endsection
