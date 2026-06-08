<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold tracking-tight text-slate-900 dark:text-white">Delete Account</h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
    </header>

    <button type="button" class="btn btn-danger" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">Delete Account</button>

    <div x-data="{ open: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }" x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 backdrop-blur-sm p-4" @click.self="open = false" @open-modal.window="open = true" @close.window="open = false" x-cloak>
        <div class="w-full max-w-md rounded-xl border border-slate-200 bg-white p-6 shadow-xl dark:border-slate-700 dark:bg-slate-900" @click.stop>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Are you sure you want to delete your account?</h2>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.</p>

            <form method="post" action="{{ route('profile.destroy') }}" class="mt-6">
                @csrf
                @method('delete')

                <div>
                    <label for="password" class="auth-label">Password</label>
                    <input id="password" name="password" type="password" class="auth-input" placeholder="Enter your password" />
                    @error('password', 'userDeletion') <p class="auth-error">{{ $message }}</p> @enderror
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" class="btn btn-outline-secondary" @click="open = false">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </div>
            </form>
        </div>
    </div>
</section>
