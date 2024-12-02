<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <div class="flex justify-center">
        <a href="{{ route('auth.google.redirect') }}" 
           class="flex items-center bg-red-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400">
            <!-- Google Icon -->
            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                <path d="M23.744 12.267c0-.813-.073-1.593-.211-2.34H12.24v4.43h6.478c-.278 1.466-1.111 2.708-2.361 3.543l-.02.138 3.428 2.63.237.024c2.18-2.011 3.442-4.975 3.442-8.425zM12.24 23.54c3.11 0 5.717-1.037 7.622-2.816l-3.634-2.788c-1.005.675-2.312 1.071-3.988 1.071-3.073 0-5.678-2.073-6.612-4.865l-.134.011-3.596 2.8-.047.13c1.893 3.772 5.91 6.456 10.39 6.456zm-6.612-9.096c-.233-.699-.364-1.443-.364-2.216s.131-1.517.364-2.216l-.007-.148-3.648-2.83-.119.057a11.991 11.991 0 00-1.593 5.137c0 1.963.479 3.81 1.327 5.452l3.676-2.965zm13.486-10.72l-3.633 2.787c-1.01-.697-2.296-1.102-3.86-1.102-4.084 0-7.533 3.215-7.533 7.145s3.45 7.145 7.533 7.145c2.041 0 3.75-.725 4.999-1.907l.147.07 3.481 2.736.12-.11c-1.925-1.781-4.308-2.866-7.222-2.866-5.58 0-10.116 4.08-10.116 9.105S6.54 24 12.24 24c4.048 0 7.598-1.903 9.947-4.895L23.744 18.7V12.267h-.002z"/>
            </svg>
            {{ __('Continue with Google') }}
        </a>
    </div>
</x-guest-layout>
