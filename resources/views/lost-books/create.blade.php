@extends('layouts.app')
@section('title', 'Record Lost Book')
@section('page-title', 'Record Lost Book')
@section('content')
<div class="surface p-6">
    <form method="POST" action="{{ route('lost-books.store') }}" class="space-y-5">
        @csrf
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label for="book_id">Book</label>
                <select id="book_id" name="book_id" required>
                    <option value="">Choose book</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" @selected(old('book_id') == $book->id)>{{ $book->title }} ({{ $book->available_copies }} available)</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('book_id')" class="mt-2" />
            </div>
            <div>
                <label for="student_id">Customer Responsible</label>
                <select id="student_id" name="student_id" required>
                    <option value="">Choose customer</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>{{ $student->full_name }} - {{ $student->registration_number }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
            </div>
            <div>
                <label for="quantity">Quantity</label>
                <input id="quantity" type="number" min="1" name="quantity" value="{{ old('quantity', 1) }}" required>
                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
            </div>
            <div>
                <label for="lost_date">Lost Date</label>
                <input id="lost_date" type="date" name="lost_date" value="{{ old('lost_date', now()->toDateString()) }}" required>
                <x-input-error :messages="$errors->get('lost_date')" class="mt-2" />
            </div>
            <div class="md:col-span-2">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes" rows="4" placeholder="Replacement plan, condition, or approval notes">{{ old('notes') }}</textarea>
                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
            </div>
        </div>
        <div class="flex flex-wrap gap-2">
            <button class="btn btn-danger">Record Lost Book</button>
            <a href="{{ route('lost-books.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
