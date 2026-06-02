@php
    $isAdmin = auth()->user()?->isAdministrator();
    $navLinks = [
        ['dashboard', 'dashboard', 'M3 13h8V3H3v10Zm0 8h8v-6H3v6Zm10 0h8V11h-8v10Zm0-18v6h8V3h-8Z', 'Dashboard'],
        ['books.*', 'books.index', 'M4 19.5A2.5 2.5 0 0 1 6.5 17H20M4 19.5A2.5 2.5 0 0 0 6.5 22H20V6H6.5A2.5 2.5 0 0 0 4 8.5v11ZM8 6V2h10v4', $isAdmin ? 'Books' : 'Available Books'],
        ['borrows.*', 'borrows.index', 'M7 7h14l-4-4M17 21l4-4H7M3 7h4M3 17h4', $isAdmin ? 'Borrowing' : 'My Borrowing'],
    ];
    if ($isAdmin) {
        $navLinks = array_merge($navLinks, [
            ['categories.*', 'categories.index', 'M7 7h.01M3 11.2V5a2 2 0 0 1 2-2h6.2a2 2 0 0 1 1.4.6l7.8 7.8a2 2 0 0 1 0 2.8l-6.2 6.2a2 2 0 0 1-2.8 0L3.6 12.6a2 2 0 0 1-.6-1.4Z', 'Categories'],
            ['students.*', 'students.index', 'M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm13 10v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75', 'Customers'],
            ['lost-books.*', 'lost-books.index', 'M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0ZM12 9v4m0 4h.01', 'Lost Books'],
        ]);
    }
    $reportLinks = $isAdmin ? [
        ['reports.borrowed', 'reports.borrowed', 'M7 7h10M7 12h10M7 17h6M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z', 'Borrowed'],
        ['reports.returned', 'reports.returned', 'M9 12l2 2 4-4M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z', 'Returned'],
        ['reports.lost', 'reports.lost', 'M12 9v4m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z', 'Lost'],
        ['reports.available', 'reports.available', 'M4 6h16M4 12h16M4 18h7', 'Available'],
        ['reports.active-students', 'reports.active-students', 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm14 10-3-3m0 0-3 3m3-3v-7', 'Active Customers'],
    ] : [];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebar: false, dark: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" x-init="$watch('dark', value => { localStorage.theme = value ? 'dark' : 'light'; document.documentElement.classList.toggle('dark', value) }); document.documentElement.classList.toggle('dark', dark)">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Knowledge Hub'))</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-shell">
        <div class="sidebar-backdrop" x-cloak x-show="sidebar" x-transition.opacity @click="sidebar = false"></div>

        <aside class="sidebar" :class="{ 'sidebar-open': sidebar }" aria-label="Main navigation">
            <div class="mb-8 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-white no-underline">
                    <x-application-logo />
                    <span>
                        <span class="block text-sm font-bold tracking-tight">Knowledge Hub</span>
                        <span class="block text-xs text-slate-400">{{ $isAdmin ? 'Administrator workspace' : 'Customer portal' }}</span>
                    </span>
                </a>
                <button class="rounded-xl p-2 text-slate-400 hover:bg-white/10 hover:text-white lg:hidden" @click="sidebar = false" aria-label="Close menu">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>

            <nav class="space-y-1">
                @foreach ($navLinks as [$match, $route, $path, $label])
                    <a class="sidebar-link {{ request()->routeIs($match) ? 'active' : '' }}" href="{{ route($route) }}">
                        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $path }}"/></svg>
                        {{ $label }}
                    </a>
                @endforeach
                @if($isAdmin)
                    <div class="sidebar-kicker">Reports</div>
                    @foreach ($reportLinks as [$match, $route, $path, $label])
                        <a class="sidebar-link {{ request()->routeIs($match) ? 'active' : '' }}" href="{{ route($route) }}">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $path }}"/></svg>
                            {{ $label }}
                        </a>
                    @endforeach
                @endif
            </nav>

            <div class="mt-auto rounded-2xl border border-white/10 bg-white/[.06] p-4">
                <div class="text-xs font-semibold uppercase tracking-widest text-slate-400">Signed in</div>
                <div class="mt-2 truncate text-sm font-semibold">{{ auth()->user()->name ?? 'Administrator' }}</div>
                <div class="truncate text-xs text-slate-400">{{ auth()->user()->email ?? '' }}</div>
            </div>
        </aside>

        <div class="main-panel">
            <header class="topbar">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex min-w-0 items-center gap-3">
                        <button class="rounded-xl border border-slate-200 bg-white p-2 text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 lg:hidden" @click="sidebar = true" aria-label="Open menu">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <div class="min-w-0">
                            <h1 class="page-title">@hasSection('page-title') @yield('page-title') @else {{ $header ?? 'Dashboard' }} @endif</h1>
                            <p class="page-subtitle">{{ $isAdmin ? 'Inventory, lending workflow, reports, and accountability controls.' : 'Browse available books and track your own borrowing requests.' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('borrows.create') }}" class="btn btn-primary hidden sm:inline-flex">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                            {{ $isAdmin ? 'Borrow' : 'Request' }}
                        </a>
                        <button class="btn btn-outline-secondary !px-3" @click="dark = !dark" aria-label="Toggle dark mode">
                            <svg x-show="!dark" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.36-6.36-1.42 1.42M7.05 16.95l-1.41 1.41m12.72 0-1.42-1.41M7.05 7.05 5.64 5.64M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/></svg>
                            <svg x-show="dark" class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z"/></svg>
                        </button>
                        <a href="{{ route('profile.edit') }}" class="hidden rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 sm:inline-flex">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-outline-danger !px-3" aria-label="Logout">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                                <span class="hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="page-wrap">
                @include('partials.flash')
                @yield('content')
                {{ $slot ?? '' }}
            </main>
        </div>
    </div>
</body>
</html>
