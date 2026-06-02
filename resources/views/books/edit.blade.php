@extends('layouts.app')
@section('title', 'Edit Book')
@section('page-title', 'Edit Book')
@section('content')
<div class="card table-card"><div class="card-body">
    <form method="POST" action="{{ route('books.update', $book) }}">@csrf @method('PUT')
        @include('books._form')
        <div class="mt-4 d-flex gap-2"><button class="btn btn-primary">Update Book</button><a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Cancel</a></div>
    </form>
</div></div>
@endsection
