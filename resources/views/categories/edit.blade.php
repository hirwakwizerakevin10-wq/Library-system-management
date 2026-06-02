@extends('layouts.app')
@section('title', 'Edit Category')
@section('page-title', 'Edit Category')
@section('content')
<div class="card table-card"><div class="card-body"><form method="POST" action="{{ route('categories.update', $category) }}">@csrf @method('PUT') @include('categories._form')<button class="btn btn-primary">Update Category</button> <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Cancel</a></form></div></div>
@endsection
