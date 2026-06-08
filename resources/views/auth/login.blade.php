<x-guest-layout>
    <div class="mb-6">
        <h1 class="auth-title">Welcome Back</h1>
        <p class="auth-subtitle">Sign in to your Knowledge Hub account</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="auth-label">Email Address</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" class="auth-input" />
            @error('email') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="auth-label">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" class="auth-input" />
            @error('password') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-900">
                <span class="ms-2 text-sm text-slate-600 dark:text-slate-300">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-indigo-600 transition hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="auth-btn-primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4m-5-4 5-5-5-5m5 5H3"/></svg>
            Sign In
        </button>

        <p class="pt-1 text-center text-sm text-slate-500 dark:text-slate-400">
            Don't have an account?
            <a class="font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300" href="{{ route('register') }}">Create one</a>
        </p>
    </form>
</x-guest-layout>
