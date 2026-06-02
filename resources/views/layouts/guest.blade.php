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
                    <x-application-logo />
                    <div>
                        <div class="font-bold">Knowledge Hub</div>
                        <div class="text-xs text-slate-300">Secure library access</div>
                    </div>
                </div>
            </div>
            <div class="relative z-10 max-w-lg">
                <div class="mb-5 inline-flex rounded-full border border-white/10 bg-white/10 px-3 py-1 text-xs font-medium text-slate-100">Knowledge Hub Access</div>
                <h1 class="text-4xl font-semibold leading-tight tracking-tight text-white">Knowledge Hub</h1>
                <p class="mt-4 max-w-md text-base leading-7 text-slate-300">A secure, business-ready portal for book discovery, borrowing requests, and library operations.</p>
            </div>
        </section>

        <section class="relative flex min-h-screen items-center justify-center px-4 py-8 sm:px-8">
            <button class="absolute right-5 top-5 btn btn-outline-secondary !border-white/10 !bg-white/10 !text-white lg:!border-slate-200 lg:!bg-white/80 lg:!text-slate-700 lg:dark:!border-slate-700 lg:dark:!bg-slate-900 lg:dark:!text-white" @click="dark = !dark" aria-label="Toggle dark mode">
                <svg x-show="!dark" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0ZM12 3v2m0 14v2M3 12h2m14 0h2"/></svg>
                <svg x-show="dark" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z"/></svg>
            </button>
            <div class="auth-card animate-fade-up">
                <div class="mb-6">
                    <x-application-logo class="mb-4 text-slate-950 dark:text-white" />
                    <h1 class="text-2xl font-semibold tracking-tight">Welcome to Knowledge Hub</h1>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Sign in to continue, or register as a customer.</p>
                </div>
                {{ $slot }}
            </div>
        </section>
    </main>
</body>
</html>
