<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" value="Name" class="text-white" />
            <x-text-input id="name"
                class="block mt-1 w-full bg-gray-700 border-gray-600 text-white focus:border-indigo-600 focus:ring-indigo-600"
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" value="Email" class="text-white" />
            <x-text-input id="email"
                class="block mt-1 w-full bg-gray-700 border-gray-600 text-white focus:border-indigo-600 focus:ring-indigo-600"
                type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" class="text-white" />
            <x-text-input id="password"
                class="block mt-1 w-full bg-gray-700 border-gray-600 text-white focus:border-indigo-600 focus:ring-indigo-600"
                type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirm Password" class="text-white" />
            <x-text-input id="password_confirmation"
                class="block mt-1 w-full bg-gray-700 border-gray-600 text-white focus:border-indigo-600 focus:ring-indigo-600"
                type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-300 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
