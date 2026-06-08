<x-guest-layout>
    <div class="mb-6">
        <h1 class="auth-title">Create Account</h1>
        <p class="auth-subtitle">Fill in your details to get started</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="auth-label">Full Name</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name" class="auth-input" />
            @error('name') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="auth-label">Email Address</label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Enter your email address" class="auth-input" />
            @error('email') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="phone" class="auth-label">Phone Number</label>
                <input id="phone" type="text" name="phone" :value="old('phone')" autocomplete="tel" placeholder="Enter your phone number" class="auth-input" />
                @error('phone') <p class="auth-error">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="department" class="auth-label">Department</label>
                <input id="department" type="text" name="department" :value="old('department')" required placeholder="e.g. Computer Science" class="auth-input" />
                @error('department') <p class="auth-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="password" class="auth-label">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Create a password" class="auth-input" />
            @error('password') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="auth-label">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat your password" class="auth-input" />
        </div>

        <button type="submit" class="auth-btn-primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg>
            Create Account
        </button>

        <p class="text-center text-sm text-slate-500 dark:text-slate-400">
            Already have an account?
            <a class="font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300" href="{{ route('login') }}">Sign in</a>
        </p>
    </form>
</x-guest-layout>
