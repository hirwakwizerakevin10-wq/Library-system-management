<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ dark: localStorage.theme === 'dark' }" x-init="$watch('dark', value => { localStorage.theme = value ? 'dark' : 'light'; document.documentElement.classList.toggle('dark', value) }); document.documentElement.classList.toggle('dark', dark)">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Knowledge Hub') }}</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <main class="auth-grid">
        <section class="auth-art">
            <div class="relative z-10">
                <div class="flex items-center gap-3">
                    <div class="khub-logo-mark">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1 0-5H20"/></svg>
                    </div>
                    <div>
                        <div class="font-bold text-white">Knowledge Hub</div>
                        <div class="text-xs text-indigo-200">Library Management System</div>
                    </div>
                </div>
            </div>
            <div class="relative z-10 max-w-lg">
                <div class="mb-5 inline-flex rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-medium text-indigo-100">Knowledge Hub Library</div>
                <h1 class="text-4xl font-semibold leading-tight tracking-tight text-white">Your Gateway to Knowledge</h1>
                <p class="mt-4 max-w-md text-base leading-7 text-indigo-200">Browse books, request borrows, and manage your reading journey — all in one place.</p>
                <div class="mt-8 flex flex-col gap-3 text-sm text-indigo-200">
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg>
                        <span>Browse & search available books</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg>
                        <span>Submit borrow requests online</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg>
                        <span>Track your borrowing history</span>
                    </div>
                </div>
            </div>
            <div class="relative z-10 text-xs text-indigo-300/60">&copy; {{ date('Y') }} Knowledge Hub. All rights reserved.</div>
        </section>

        <section class="relative flex min-h-screen items-center justify-center px-4 py-8 sm:px-8">
            <button class="absolute right-5 top-5 btn-auth-toggle" @click="dark = !dark" aria-label="Toggle dark mode">
                <svg x-show="!dark" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 3v2m0 14v2M3 12h2m14 0h2"/></svg>
                <svg x-show="dark" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z"/></svg>
            </button>
            <div class="auth-card animate-fade-up">
                {{ $slot }}
            </div>
        </section>
    </main>
</body>
</html>
