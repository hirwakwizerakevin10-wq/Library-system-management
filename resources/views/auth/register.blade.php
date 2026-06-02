<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Full name')" />
            <x-text-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Customer full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email address')" />
            <x-text-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="you@library.edu" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" class="mt-1 block w-full" type="text" name="phone" :value="old('phone')" autocomplete="tel" placeholder="Optional" />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="department" :value="__('Department/Class')" />
                <x-text-input id="department" class="mt-1 block w-full" type="text" name="department" :value="old('department')" required placeholder="Business, Science..." />
                <x-input-error :messages="$errors->get('department')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="new-password" placeholder="Create a secure password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm password')" />
            <x-text-input id="password_confirmation" class="mt-1 block w-full" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat your password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button class="btn btn-primary w-full" type="submit">{{ __('Register customer account') }}</button>

        <p class="text-center text-sm text-slate-500 dark:text-slate-400">
            Already registered?
            <a class="font-semibold text-brand-600 hover:text-brand-700 dark:text-brand-100" href="{{ route('login') }}">{{ __('Sign in') }}</a>
        </p>
    </form>
</x-guest-layout>
