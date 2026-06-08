<x-guest-layout>
    <div class="mb-6">
        <h1 class="auth-title">Confirm Password</h1>
        <p class="auth-subtitle">This is a secure area. Please confirm your password before continuing.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <label for="password" class="auth-label">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" class="auth-input" />
            @error('password') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="auth-btn-primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            Confirm
        </button>
    </form>
</x-guest-layout>
