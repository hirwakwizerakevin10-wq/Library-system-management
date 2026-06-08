<x-guest-layout>
    <div class="mb-6">
        <h1 class="auth-title">Reset Password</h1>
        <p class="auth-subtitle">Enter your new password below</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label for="email" class="auth-label">Email Address</label>
            <input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="Enter your email" class="auth-input" />
            @error('email') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="auth-label">New Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create a new password" class="auth-input" />
            @error('password') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="auth-label">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat your password" class="auth-input" />
        </div>

        <button type="submit" class="auth-btn-primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            Reset Password
        </button>
    </form>
</x-guest-layout>
