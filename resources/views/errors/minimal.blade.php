<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Something went wrong' }} - {{ config('app.name', 'Knowledge Hub') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 text-gray-900 antialiased">
    <main class="flex min-h-screen items-center justify-center px-6 py-12">
        <section class="w-full max-w-lg rounded-lg bg-white p-8 text-center shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wider text-indigo-600">{{ $code ?? 'Error' }}</p>
            <h1 class="mt-3 text-2xl font-bold">{{ $title ?? 'Something went wrong' }}</h1>
            <p class="mt-3 text-gray-600">{{ $message ?? 'The request could not be completed. Please try again.' }}</p>
            <div class="mt-6 flex justify-center gap-3">
                <a href="{{ url()->previous() }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Go back</a>
                <a href="{{ route('dashboard') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Dashboard</a>
            </div>
        </section>
    </main>
</body>
</html>
