<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ dark: localStorage.theme === 'dark' }" x-init="$watch('dark', value => { localStorage.theme = value ? 'dark' : 'light'; document.documentElement.classList.toggle('dark', value) }); document.documentElement.classList.toggle('dark', dark)">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Knowledge Hub') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/85 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-950/80">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="brand-mark">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M4 19.5A2.5 2.5 0 0 0 6.5 22H20V6H6.5A2.5 2.5 0 0 0 4 8.5v11Z"/></svg>
                </span>
                <span>
                    <span class="block text-sm font-bold tracking-tight">Knowledge Hub</span>
                    <span class="block text-xs text-slate-500 dark:text-slate-400">Kigali library platform</span>
                </span>
            </a>
            <nav class="hidden items-center gap-6 text-sm font-medium text-slate-600 dark:text-slate-300 md:flex">
                <a href="#catalog" class="hover:text-slate-950 dark:hover:text-white">Catalog</a>
                <a href="#services" class="hover:text-slate-950 dark:hover:text-white">Services</a>
                <a href="#testimonials" class="hover:text-slate-950 dark:hover:text-white">Clients</a>
            </nav>
            <div class="flex items-center gap-2">
                <button class="btn btn-outline-secondary !px-3" @click="dark = !dark" aria-label="Toggle dark mode">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z"/></svg>
                </button>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary hidden sm:inline-flex">Sign in</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Get started</a>
                @endauth
            </div>
        </div>
    </header>

    <main>
        <section class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[1.05fr_.95fr] lg:px-8 lg:py-20">
            <div>
                <div class="mb-5 inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-800 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-100">Built for schools, reading rooms, and community libraries in Kigali</div>
                <h1 class="max-w-3xl text-4xl font-bold leading-tight tracking-tight text-slate-950 dark:text-white sm:text-5xl">Library management that feels organized from the first day.</h1>
                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-300">Manage books, customers, borrowings, returns, lost items, and operational reports from one calm, reliable platform designed for real library teams.</p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('register') }}" class="btn btn-primary">Start library setup</a>
                    <a href="#catalog" class="btn btn-outline-primary">Explore catalog</a>
                </div>
                <div class="mt-8 grid max-w-lg grid-cols-3 gap-3">
                    <div class="metric"><div class="text-2xl font-bold">{{ number_format($bookCount) }}</div><div class="mt-1 text-xs text-slate-500">Books tracked</div></div>
                    <div class="metric"><div class="text-2xl font-bold">{{ number_format($studentCount) }}</div><div class="mt-1 text-xs text-slate-500">Customers</div></div>
                    <div class="metric"><div class="text-2xl font-bold">24/7</div><div class="mt-1 text-xs text-slate-500">Access</div></div>
                </div>
            </div>

            <div class="surface p-4 sm:p-6">
                <div class="rounded-lg bg-slate-950 p-5 text-white">
                    <div class="mb-5 flex items-center justify-between">
                        <div>
                            <div class="text-sm font-semibold">Today at the front desk</div>
                            <div class="text-xs text-slate-400">Live lending overview</div>
                        </div>
                        <span class="badge bg-emerald-500/15 text-emerald-200">Open</span>
                    </div>
                    <div class="grid gap-3 sm:grid-cols-3">
                        <div class="rounded-lg bg-white/10 p-4"><div class="text-2xl font-bold">36</div><div class="text-xs text-slate-300">Checkouts</div></div>
                        <div class="rounded-lg bg-white/10 p-4"><div class="text-2xl font-bold">12</div><div class="text-xs text-slate-300">Returns due</div></div>
                        <div class="rounded-lg bg-white/10 p-4"><div class="text-2xl font-bold">98%</div><div class="text-xs text-slate-300">Available data</div></div>
                    </div>
                    <div class="mt-5 space-y-3">
                        @foreach ($featuredBooks->take(3) as $book)
                            <div class="flex items-center justify-between rounded-lg bg-white/8 p-3">
                                <div>
                                    <div class="text-sm font-semibold">{{ $book->title }}</div>
                                    <div class="text-xs text-slate-400">{{ $book->author }}</div>
                                </div>
                                <span class="badge bg-white/10 text-slate-100">{{ $book->available_copies }} copies</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section id="catalog" class="border-y border-slate-200/80 bg-white/70 py-14 dark:border-slate-800 dark:bg-slate-900/40">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-semibold tracking-tight">Featured Available Books</h2>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">A public-facing preview of what readers can discover.</p>
                    </div>
                    <form action="{{ route('books.index') }}" class="flex w-full gap-2 sm:w-auto">
                        <input name="search" placeholder="Search after sign in" aria-label="Search books">
                        <button class="btn btn-outline-primary">Search</button>
                    </form>
                </div>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @forelse ($featuredBooks as $book)
                        <article class="card p-5">
                            <div class="mb-4 flex items-start justify-between gap-3">
                                <div class="grid h-12 w-12 place-items-center rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-200">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M20 22V6H6.5A2.5 2.5 0 0 0 4 8.5v11"/></svg>
                                </div>
                                <span class="badge text-bg-success">{{ $book->available_copies }} available</span>
                            </div>
                            <h3 class="font-semibold text-slate-950 dark:text-white">{{ $book->title }}</h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $book->author }}</p>
                            <div class="mt-4 text-xs font-medium text-slate-500">{{ $book->category->name ?? 'General' }} · {{ $book->shelf_location ?: 'Main shelf' }}</div>
                        </article>
                    @empty
                        <div class="empty-state card md:col-span-2 lg:col-span-3">No public books are available yet.</div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="services" class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-3">
                @foreach ([['Catalog control', 'Keep ISBNs, shelves, copies, categories, and availability clean.'], ['Borrowing workflow', 'Record checkouts, due dates, returns, lost items, and notes with audit history.'], ['Owner reporting', 'See available books, active customers, returned books, and accountability reports.']] as [$title, $body])
                    <div class="card p-6">
                        <h3 class="font-semibold">{{ $title }}</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-500 dark:text-slate-400">{{ $body }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section id="testimonials" class="bg-slate-950 py-14 text-white">
            <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-3 lg:px-8">
                @foreach ([['Aline M.', 'School librarian', 'The dashboard makes borrowing and returns easy to explain to staff.'], ['Jean P.', 'Library owner', 'It gives our small team the confidence of a professional system.'], ['Grace N.', 'Academic coordinator', 'Customers can be tracked clearly, and reports are ready when management asks.']] as [$name, $role, $quote])
                    <figure class="rounded-lg border border-white/10 bg-white/[.06] p-6">
                        <blockquote class="text-sm leading-7 text-slate-200">"{{ $quote }}"</blockquote>
                        <figcaption class="mt-5 text-sm font-semibold">{{ $name }} <span class="font-normal text-slate-400">· {{ $role }}</span></figcaption>
                    </figure>
                @endforeach
            </div>
        </section>
    </main>

    <footer class="border-t border-slate-200 bg-white py-8 dark:border-slate-800 dark:bg-slate-950">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <p>&copy; {{ date('Y') }} Knowledge Hub. Built for dependable library operations.</p>
            <div class="flex gap-4"><a href="{{ route('login') }}">Admin login</a><a href="#services">Services</a></div>
        </div>
    </footer>
</body>
</html>
