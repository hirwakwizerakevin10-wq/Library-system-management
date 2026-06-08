@extends('layouts.app')
@section('title', 'Add Book')
@section('page-title', 'Add Book')
@section('content')
<div class="card table-card">
    <div class="card-body">
        <form method="POST" action="{{ route('books.store') }}">
            @csrf
            @include('books._form')
            <div class="mt-4 flex flex-wrap gap-2">
                <button class="btn btn-primary">Save Book</button>
                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
