@extends('layouts.app')
@section('title', 'Edit Customer')
@section('page-title', 'Edit Customer')
@section('content')
<div class="card table-card"><div class="card-body"><form method="POST" action="{{ route('students.update', $student) }}">@csrf @method('PUT') @include('students._form')<div class="mt-4"><button class="btn btn-primary">Update Customer</button> <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Cancel</a></div></form></div></div>
@endsection
