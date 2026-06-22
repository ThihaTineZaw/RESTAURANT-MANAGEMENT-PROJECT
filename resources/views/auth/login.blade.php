<x-login-layout>
    <div class="p-6 sm:p-8">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-white mb-2">{{ config('app.name', 'Restaurant Management Project') }}</h1>
            <p class="text-sm text-white">Welcome back! Please login to your account</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Message Error -->
        @if($errors->has('message'))
            <div class="mb-4 p-3 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-sm text-center border border-red-200 dark:border-red-800">
                {{ $errors->first('message') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" class="text-white" />
                <x-text-input id="name" class="block mt-1 w-full px-4 py-3 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200" type="text" name="name" :value="old('name')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-6">
                <x-input-label for="password" :value="__('Password')" class="text-white" />
                <x-text-input id="password" class="block mt-1 w-full px-4 py-3 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                              type="password"
                              name="password"
                              required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="mb-6">
                <label for="remember_me" class="inline-flex items-center cursor-pointer ">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-primary-600 shadow-sm focus:ring-primary-500 bg-white dark:bg-gray-900" name="remember">
                    <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-center ">
                <x-primary-button class="w-full py-3 flex justify-center items-center font-semibold bg-primary-600 hover:bg-primary-700 rounded-lg transition-colors duration-200 " >
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-login-layout>
