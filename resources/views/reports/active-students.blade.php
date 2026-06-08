@extends('layouts.app')
@section('title', 'Customers With Active Borrowings')
@section('page-title', 'Customers With Active Borrowings')
@section('content')
<div class="mb-6">
    <div class="metric inline-block"><div class="text-2xl font-bold">{{ $students->total() }}</div><div class="text-sm text-slate-500">Customers with active borrows</div></div>
</div>
<div class="card table-card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead><tr><th>Customer</th><th>Registration</th><th>Department</th><th>Active Books</th></tr></thead>
            <tbody>
            @forelse($students as $student)
                <tr>
                    <td class="font-semibold">{{ $student->full_name }}</td>
                    <td class="font-mono text-xs">{{ $student->registration_number }}</td>
                    <td>{{ $student->department }}</td>
                    <td>
                        <div class="flex flex-wrap gap-1">
                            @foreach($student->borrows as $borrow)
                                <span class="badge badge-soft">{{ $borrow->book->title }}</span>
                            @endforeach
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No customers have active borrowings.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">{{ $students->links() }}</div>
</div>
@endsection
