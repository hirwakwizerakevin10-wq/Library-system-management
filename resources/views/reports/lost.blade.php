@extends('layouts.app')
@section('title', 'Lost Books Report')
@section('page-title', 'Lost Books Report')
@section('content')
@php
    $totalLost = $lostBooks->sum('quantity');
@endphp
<div class="mb-6">
    <div class="metric inline-block"><div class="text-2xl font-bold">{{ $totalLost }}</div><div class="text-sm text-slate-500">Total copies lost</div></div>
</div>
<div class="card table-card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Book</th><th>Customer</th><th>Qty</th><th>Lost Date</th><th>Notes</th></tr></thead>
            <tbody>
            @forelse($lostBooks as $lost)
                <tr>
                    <td class="font-semibold">{{ $lost->book->title }}</td>
                    <td>{{ $lost->student->full_name }}</td>
                    <td>{{ $lost->quantity }}</td>
                    <td>{{ $lost->lost_date->format('M d, Y') }}</td>
                    <td class="max-w-xs truncate">{{ $lost->notes ?: '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No lost books recorded.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $lostBooks->links() }}</div>
</div>
@endsection
