<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Email" class="text-white" />
            <x-text-input id="email"
                class="block mt-1 w-full bg-gray-700 border-gray-600 text-white focus:border-indigo-600 focus:ring-indigo-600"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" class="text-white" />
            <x-text-input id="password"
                class="block mt-1 w-full bg-gray-700 border-gray-600 text-white focus:border-indigo-600 focus:ring-indigo-600"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-600 bg-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-600 focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-300">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-300 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-300">
                {{ __("Don't have an account?") }}
                <a class="underline text-indigo-400 hover:text-indigo-300" href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
