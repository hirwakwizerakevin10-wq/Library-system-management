@extends('layouts.app')
@section('title', 'Profile')
@section('page-title', 'Profile')
@section('content')
<div class="grid gap-6 lg:grid-cols-[.8fr_1.2fr]">
    <aside class="surface p-6">
        <div class="flex items-center gap-4">
            <div class="grid h-16 w-16 place-items-center rounded-3xl bg-gradient-to-br from-indigo-600 to-violet-500 text-xl font-bold text-white shadow-lg">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="min-w-0">
                <h2 class="truncate text-xl font-bold tracking-tight">{{ $user->name }}</h2>
                <p class="truncate text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
            </div>
        </div>
        <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600 dark:border-slate-800 dark:bg-slate-950/40 dark:text-slate-300">
            Manage your account details, password, and preferences from one focused workspace.
        </div>
    </aside>

    <div class="space-y-6">
        <div class="surface p-6">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="surface p-6">
            @include('profile.partials.update-password-form')
        </div>
        <div class="surface p-6 border-rose-200/80 dark:border-rose-500/20">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
