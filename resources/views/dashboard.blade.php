@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@if(auth()->user()->isCustomer())
<section class="grid gap-5 lg:grid-cols-[1.1fr_.9fr]">
    <div class="surface p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-semibold tracking-tight">Available Books</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Browse books currently available for request.</p>
            </div>
            <a href="{{ route('books.index') }}" class="btn btn-outline-primary btn-sm">View catalog</a>
        </div>
        <div class="mt-5 grid gap-3 sm:grid-cols-2">
            @forelse($availableBooks as $book)
                <article class="rounded-lg border border-slate-200 bg-slate-50 p-4 transition hover:-translate-y-0.5 hover:bg-white dark:border-slate-800 dark:bg-slate-950/40 dark:hover:bg-slate-900">
                    <div class="text-sm font-semibold text-slate-950 dark:text-white">{{ $book->title }}</div>
                    <div class="mt-1 text-xs text-slate-500">{{ $book->author }}</div>
                    <div class="mt-3 flex items-center justify-between gap-3">
                        <span class="badge badge-soft">{{ $book->category->name }}</span>
                        <span class="text-xs font-semibold text-emerald-700 dark:text-emerald-200">{{ $book->available_copies }} available</span>
                    </div>
                </article>
            @empty
                <div class="empty-state sm:col-span-2">No books are currently available.</div>
            @endforelse
        </div>
    </div>

    <aside class="space-y-5">
        <div class="grid grid-cols-2 gap-4">
            <div class="metric"><div class="text-2xl font-bold">{{ $pendingRequests }}</div><div class="text-sm text-slate-500">Pending requests</div></div>
            <div class="metric"><div class="text-2xl font-bold">{{ $activeBorrows }}</div><div class="text-sm text-slate-500">Active borrows</div></div>
        </div>
        <div class="surface p-6">
            <h2 class="text-lg font-semibold tracking-tight">My Recent Records</h2>
            <div class="mt-4 space-y-3">
                @forelse($customerBorrows as $borrow)
                    @php
                        $isOverdue = $borrow->status === 'borrowed' && $borrow->due_date->isPast();
                    @endphp
                    <a href="{{ route('borrows.show', $borrow) }}" class="block rounded-lg border border-slate-200 p-4 transition hover:-translate-y-0.5 hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-950/50">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="font-semibold">{{ $borrow->book->title }}</div>
                                <div class="mt-1 text-xs text-slate-500">Due {{ $borrow->due_date->format('M d, Y') }}</div>
                            </div>
                            <span class="badge text-bg-{{ $borrow->status === 'pending' ? 'info' : ($borrow->status === 'borrowed' ? ($isOverdue ? 'danger' : 'warning') : ($borrow->status === 'rejected' || $borrow->status === 'lost' ? 'danger' : 'success')) }}">{{ $isOverdue ? 'Overdue' : ucfirst($borrow->status) }}</span>
                        </div>
                    </a>
                @empty
                    <div class="empty-state">No borrowing records yet.</div>
                @endforelse
            </div>
        </div>
        <a href="{{ route('borrows.create') }}" class="btn btn-primary w-full">Request a Book</a>
    </aside>
</section>
@else
@php
    $stats = [
        ['Total Books', $totalBooks, 'Full inventory capacity', 'M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5A2.5 2.5 0 0 0 6.5 22H20V6H6.5A2.5 2.5 0 0 0 4 8.5v11Z', 'from-blue-500 to-cyan-400'],
        ['Available', $availableBooks, 'Ready to borrow today', 'M20 6 9 17l-5-5', 'from-emerald-500 to-teal-400'],
        ['Borrowed', $borrowedBooks, 'Active lending records', 'M7 7h14l-4-4M17 21l4-4H7', 'from-amber-500 to-orange-400'],
        ['Pending', $pendingBorrows, 'Requests awaiting approval', 'M12 8v5l3 3M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z', 'from-sky-500 to-blue-400'],
        ['Lost', $lostBooks, 'Recorded accountability', 'M12 9v4m0 4h.01M10.29 3.86 1.82 18h20.36L13.71 3.86a2 2 0 0 0-3.42 0Z', 'from-rose-500 to-pink-400'],
        ['Customers', $totalStudents, 'Registered borrowers', 'M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z', 'from-violet-500 to-indigo-400'],
    ];
@endphp

<section class="mb-6 grid gap-4 md:grid-cols-2 xl:grid-cols-6">
    @foreach ($stats as [$label, $value, $caption, $path, $gradient])
        <article class="stat-card group p-5">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $label }}</p>
                    <p class="mt-2 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">{{ $value }}</p>
                </div>
                <div class="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br {{ $gradient }} text-white shadow-glow transition group-hover:scale-105">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $path }}"/></svg>
                </div>
            </div>
            <p class="mt-4 text-xs font-medium text-slate-500 dark:text-slate-400">{{ $caption }}</p>
        </article>
    @endforeach
</section>

<section class="grid gap-6 xl:grid-cols-[1.45fr_.85fr]">
    <div class="surface p-6">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold tracking-tight">Inventory Pulse</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Availability, borrowings, and losses at a glance.</p>
            </div>
            <a href="{{ route('reports.available') }}" class="btn btn-outline-primary btn-sm">View report</a>
        </div>
        <div class="grid gap-4 md:grid-cols-3">
            @foreach ([['Available', $availableBooks, 'bg-emerald-500'], ['Borrowed', $borrowedBooks, 'bg-amber-500'], ['Lost', $lostBooks, 'bg-rose-500']] as [$name, $value, $color])
                <div class="rounded-2xl border border-slate-200/80 bg-slate-50/70 p-4 dark:border-slate-800 dark:bg-slate-950/40">
                    <div class="flex items-center justify-between text-sm">
                        <span class="font-medium text-slate-600 dark:text-slate-300">{{ $name }}</span>
                        <span class="font-bold">{{ $value }}</span>
                    </div>
                    <div class="mt-4 h-2 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-800">
                        <div class="h-full rounded-full {{ $color }}" style="width: {{ max(8, min(100, ($value / max(1, $totalBooks)) * 100)) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6 flex h-56 items-end gap-3 rounded-3xl border border-slate-200/80 bg-gradient-to-b from-slate-50 to-white p-5 dark:border-slate-800 dark:from-slate-950/60 dark:to-slate-900/60">
            @php
                $maxCat = max(1, $categoryStats->max('books_count'));
            @endphp
            @forelse($categoryStats as $cat)
                <div class="flex flex-1 flex-col items-center gap-2">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-200">{{ $cat->books_count }}</span>
                    <div class="w-full rounded-t-xl bg-gradient-to-t from-indigo-600 to-violet-400 opacity-85 transition duration-300 hover:opacity-100" style="height: {{ max(8, ($cat->books_count / $maxCat) * 100) }}%"></div>
                    <span class="text-[10px] font-medium text-slate-500 text-center leading-tight">{{ Str::limit($cat->name, 10) }}</span>
                </div>
            @empty
                <div class="flex flex-1 items-center justify-center text-sm text-slate-400">No category data yet</div>
            @endforelse
        </div>
    </div>

    <div class="space-y-6">
        <div class="surface p-6">
            <h2 class="text-lg font-semibold tracking-tight">Quick Actions</h2>
            <div class="mt-4 grid gap-3">
                <a href="{{ route('borrows.create') }}" class="btn btn-primary justify-between">Borrow Book <span>+</span></a>
                <a href="{{ route('books.create') }}" class="btn btn-outline-primary justify-between">Add Book <span>+</span></a>
                <a href="{{ route('students.create') }}" class="btn btn-outline-secondary justify-between">Add Customer <span>+</span></a>
                <a href="{{ route('lost-books.create') }}" class="btn btn-outline-danger justify-between">Record Lost <span>!</span></a>
            </div>
        </div>
        <div class="surface p-6">
            <h2 class="text-lg font-semibold tracking-tight">Operational Health</h2>
            <div class="mt-5 space-y-4">
                <div class="flex items-center justify-between"><span class="text-sm text-slate-500">Availability ratio</span><span class="font-semibold">{{ round(($availableBooks / max(1, $totalBooks)) * 100) }}%</span></div>
                <div class="flex items-center justify-between"><span class="text-sm text-slate-500">Active borrowers</span><span class="font-semibold">{{ $borrowedBooks }}</span></div>
                <div class="flex items-center justify-between"><span class="text-sm text-slate-500">Loss records</span><span class="font-semibold">{{ $lostBooks }}</span></div>
            </div>
        </div>
    </div>
</section>

<section class="mt-6 surface">
    <div class="card-header flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-semibold tracking-tight">Recent Borrow Activities</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Latest lending events and return status.</p>
        </div>
        <a href="{{ route('borrows.index') }}" class="btn btn-outline-secondary btn-sm">View all</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Customer</th><th>Book</th><th>Due</th><th>Status</th></tr></thead>
            <tbody>
            @forelse ($recentBorrows as $borrow)
                <tr>
                    <td class="font-semibold">{{ $borrow->student->full_name }}</td>
                    <td>{{ $borrow->book->title }}</td>
                    <td>{{ $borrow->due_date->format('M d, Y') }}</td>
                    <td><span class="badge text-bg-{{ $borrow->status === 'borrowed' ? 'warning' : ($borrow->status === 'lost' ? 'danger' : 'success') }}">{{ ucfirst($borrow->status) }}</span></td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No borrowing activity yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endif
@endsection
