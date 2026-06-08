<section>
    <header class="mb-6">
        <h2 class="text-lg font-semibold tracking-tight text-slate-900 dark:text-white">Profile Information</h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Update your account's profile information and email address.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="auth-label">Name</label>
            <input id="name" name="name" type="text" class="auth-input" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            @error('name') <p class="auth-error">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="auth-label">Email</label>
            <input id="email" name="email" type="email" class="auth-input" :value="old('email', $user->email)" required autocomplete="username" />
            @error('email') <p class="auth-error">{{ $message }}</p> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Your email address is unverified.
                        <button form="send-verification" class="font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">
                            Click here to re-send the verification email.
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 font-medium text-sm text-emerald-600 dark:text-emerald-400">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="auth-btn-primary !w-auto">Save</button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-emerald-600 dark:text-emerald-400">Saved.</p>
            @endif
        </div>
    </form>
</section>
