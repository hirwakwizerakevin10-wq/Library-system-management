<x-guest-layout>
    <div class="mb-6">
        <h1 class="auth-title">Forgot Password?</h1>
        <p class="auth-subtitle">No problem. Just let us know your email address and we will send you a password reset link.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="auth-label">Email Address</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" class="auth-input" />
            @error('email') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="auth-btn-primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Send Reset Link
        </button>

        <p class="text-center text-sm text-slate-500 dark:text-slate-400">
            <a class="font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400" href="{{ route('login') }}">Back to login</a>
        </p>
    </form>
</x-guest-layout>
