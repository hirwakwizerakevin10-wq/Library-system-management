@extends('layouts.app')
@section('title', 'Lost Book Record')
@section('page-title', 'Lost Book Record')
@section('content')
<div class="surface p-6">
    <span class="badge text-bg-danger">Lost record</span>
    <h2 class="mt-3 text-2xl font-semibold">{{ $lostBook->book->title }}</h2>
    <p class="mt-1 text-slate-500 dark:text-slate-400">Recorded against {{ $lostBook->student->full_name }} on {{ $lostBook->lost_date->format('M d, Y') }}</p>
    <div class="mt-6 grid gap-4 md:grid-cols-3">
        <div class="metric"><div class="text-sm text-slate-500">Quantity</div><div class="mt-1 font-semibold">{{ $lostBook->quantity }}</div></div>
        <div class="metric"><div class="text-sm text-slate-500">Customer</div><div class="mt-1 font-semibold">{{ $lostBook->student->registration_number }}</div></div>
        <div class="metric"><div class="text-sm text-slate-500">Linked Borrowing</div><div class="mt-1 font-semibold">{{ $lostBook->borrow_id ? '#'.$lostBook->borrow_id : 'Standalone' }}</div></div>
    </div>
    <div class="mt-6 rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm dark:border-slate-800 dark:bg-slate-950/40">{{ $lostBook->notes ?: 'No notes provided.' }}</div>
</div>
@endsection
