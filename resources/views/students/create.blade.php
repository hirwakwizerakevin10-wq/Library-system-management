@extends('layouts.app')
@section('title', 'Add Customer')
@section('page-title', 'Add Customer')
@section('content')
<div class="card table-card"><div class="card-body"><form method="POST" action="{{ route('students.store') }}">@csrf @include('students._form')<div class="mt-4"><button class="btn btn-primary">Save Customer</button> <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">Cancel</a></div></form></div></div>
@endsection
