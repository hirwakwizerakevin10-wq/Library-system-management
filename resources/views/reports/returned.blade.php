@extends('layouts.app')
@section('title', 'Returned Books Report')
@section('page-title', 'Returned Books Report')
@section('content')
<div class="mb-6">
    <div class="metric inline-block"><div class="text-2xl font-bold">{{ $borrows->total() }}</div><div class="text-sm text-slate-500">Total returned</div></div>
</div>
<div class="card table-card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Book</th><th>Customer</th><th>Borrowed</th><th>Returned</th></tr></thead>
            <tbody>
            @forelse($borrows as $borrow)
                <tr>
                    <td class="font-semibold">{{ $borrow->book->title }}</td>
                    <td>{{ $borrow->student->full_name }}</td>
                    <td>{{ $borrow->borrow_date->format('M d, Y') }}</td>
                    <td>{{ $borrow->return_date?->format('M d, Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No returned books yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $borrows->links() }}</div>
</div>
@endsection
