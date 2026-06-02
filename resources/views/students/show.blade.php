@extends('layouts.app')
@section('title', $student->full_name)
@section('page-title', 'Customer Profile')
@section('content')
<div class="grid gap-6 lg:grid-cols-[.8fr_1.2fr]">
    <aside class="surface p-6">
        <div class="mb-4 grid h-14 w-14 place-items-center rounded-lg bg-brand-50 text-brand-700 dark:bg-brand-500/10 dark:text-brand-100">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><path d="M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/></svg>
        </div>
        <h2 class="text-2xl font-semibold">{{ $student->full_name }}</h2>
        <p class="mt-1 text-slate-500">{{ $student->registration_number }}</p>
        <div class="mt-6 space-y-3 text-sm">
            <div class="metric"><div class="text-slate-500">Email</div><div class="font-semibold">{{ $student->email }}</div></div>
            <div class="metric"><div class="text-slate-500">Phone</div><div class="font-semibold">{{ $student->phone ?: 'Not provided' }}</div></div>
            <div class="metric"><div class="text-slate-500">Department/Class</div><div class="font-semibold">{{ $student->department }}</div></div>
        </div>
        <div class="mt-6 flex gap-2"><a href="{{ route('students.edit', $student) }}" class="btn btn-primary">Edit</a><a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Back</a></div>
    </aside>
    <section class="surface">
        <div class="card-header"><h2 class="text-lg font-semibold">Borrowing History</h2></div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>Book</th><th>Borrowed</th><th>Due</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($student->borrows as $borrow)
                    <tr><td>{{ $borrow->book->title }}</td><td>{{ $borrow->borrow_date->format('M d, Y') }}</td><td>{{ $borrow->due_date->format('M d, Y') }}</td><td><span class="badge text-bg-{{ $borrow->status === 'borrowed' ? 'warning' : ($borrow->status === 'lost' ? 'danger' : 'success') }}">{{ ucfirst($borrow->status) }}</span></td></tr>
                @empty
                    <tr><td colspan="4"><div class="empty-state">No borrowing history yet.</div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
