<section>
    <header class="mb-6">
        <h2 class="text-lg font-semibold tracking-tight text-slate-900 dark:text-white">Update Password</h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Ensure your account is using a long, random password to stay secure.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="auth-label">Current Password</label>
            <input id="update_password_current_password" name="current_password" type="password" class="auth-input" autocomplete="current-password" />
            @error('current_password') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="update_password_password" class="auth-label">New Password</label>
            <input id="update_password_password" name="password" type="password" class="auth-input" autocomplete="new-password" />
            @error('password') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="auth-label">Confirm Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="auth-input" autocomplete="new-password" />
            @error('password_confirmation') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="auth-btn-primary !w-auto">Save</button>
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-emerald-600 dark:text-emerald-400">Saved.</p>
            @endif
        </div>
    </form>
</section>
