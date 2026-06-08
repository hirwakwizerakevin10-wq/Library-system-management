<x-guest-layout>
    <div class="mb-6">
        <h1 class="auth-title">Verify Email</h1>
        <p class="auth-subtitle">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-5 flex items-center gap-2 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:border-emerald-500/20 dark:bg-emerald-500/10 dark:text-emerald-300">
            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg>
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="flex flex-col gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="auth-btn-primary">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="auth-btn-primary !bg-slate-900 hover:!bg-slate-800 dark:!bg-white dark:!text-slate-950 dark:hover:!bg-slate-200">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                Log Out
            </button>
        </form>
    </div>
</x-guest-layout>
