@extends('layouts.app')
@section('title', auth()->user()->isAdministrator() ? 'Borrow Book' : 'Request Book')
@section('page-title', auth()->user()->isAdministrator() ? 'New Borrowing' : 'Request a Book')
@section('content')
@php
    $isAdmin = auth()->user()->isAdministrator();
@endphp
<div class="grid gap-6 lg:grid-cols-[1fr_.45fr]">
    <div class="surface p-6">
        <form method="POST" action="{{ route('borrows.store') }}" class="space-y-5">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                @if($isAdmin)
                <div>
                    <label for="student_id">Customer</label>
                    <select id="student_id" name="student_id" required>
                        <option value="">Choose customer</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>{{ $student->full_name }} - {{ $student->registration_number }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                </div>
                @endif
                <div>
                    <label for="book_id">Available Book</label>
                    <select id="book_id" name="book_id" required>
                        <option value="">Choose book</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" @selected(old('book_id', request('book_id')) == $book->id)>{{ $book->title }} by {{ $book->author }} ({{ $book->available_copies }} available)</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('book_id')" class="mt-2" />
                </div>
                @if($isAdmin)
                <div>
                    <label for="borrow_date">Borrow Date</label>
                    <input id="borrow_date" type="date" name="borrow_date" value="{{ old('borrow_date', now()->toDateString()) }}" required>
                    <x-input-error :messages="$errors->get('borrow_date')" class="mt-2" />
                </div>
                <div>
                    <label for="due_date">Due Date</label>
                    <input id="due_date" type="date" name="due_date" value="{{ old('due_date', now()->addDays(14)->toDateString()) }}" required>
                    <x-input-error :messages="$errors->get('due_date')" class="mt-2" />
                </div>
                @endif
                <div class="md:col-span-2">
                    <label for="notes">Notes</label>
                    <textarea id="notes" name="notes" rows="4" placeholder="Condition, special approval, or desk notes">{{ old('notes') }}</textarea>
                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <button class="btn btn-primary">{{ $isAdmin ? 'Confirm Borrowing' : 'Submit Request' }}</button>
                <a href="{{ route('borrows.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
    <aside class="surface p-6">
        <h2 class="text-lg font-semibold">{{ $isAdmin ? 'Lending checklist' : 'Request details' }}</h2>
        <div class="mt-4 space-y-3 text-sm text-slate-600 dark:text-slate-300">
            @if($isAdmin)
                <p>Confirm the customer identity and registration number before issuing the book.</p>
                <p>Use a realistic due date and record any visible book damage in the notes.</p>
                <p>Only books with available copies appear in this form.</p>
            @else
                <p>Your request will remain pending until an administrator approves it.</p>
                <p>Only available books can be requested.</p>
                <p>Your borrowing records are visible only to you and administrators.</p>
            @endif
        </div>
    </aside>
</div>
@endsection
