@extends('layouts.app')
@section('title', 'Add Category')
@section('page-title', 'Add Category')
@section('content')
<div class="card table-card"><div class="card-body"><form method="POST" action="{{ route('categories.store') }}">@csrf @include('categories._form')<button class="btn btn-primary">Save Category</button> <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Cancel</a></form></div></div>
@endsection
