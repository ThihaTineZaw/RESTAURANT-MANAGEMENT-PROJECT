<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Restaurant Management') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function() {
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'true' || (!darkMode && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>

<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    <div id="app" class="min-h-screen flex flex-col">
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-40 transition-colors duration-200">
            <div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <button id="mobile-menu-btn" class="block lg:hidden p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <button class="hidden lg:hidden  p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700" id="close-sidebar-btn">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <div class="flex-shrink-0 flex items-center ml-3 lg:ml-0">
                            <span class="text-xl font-semibold text-gray-900 dark:text-white">{{ config('app.name', 'Restaurant') }}</span>
                        </div>
                    </div>
                   
                        <div class="flex items-center">
                            <div class="flex items-center gap-4">
                                @auth
                                <span class="text-sm text-gray-600 dark:text-gray-400 font-bold ">{{ ucfirst(Auth::user()->name) }}</span>
                                <a href="{{ route('logout') }}" class="text-sm  bg-red-500 text-white py-1  dark:text-white  dark:hover:text-white hover:bg-red-700 dark:hover:bg-red-700 px-2 rounded-lg ">Logout</a>
                                @endauth
                            </div>
                        </div>
        
                </div>
            </div>
        </nav>

        @if(session('success'))
        <div class="bg-primary-50 dark:bg-primary-950 border-b border-primary-200 dark:border-primary-800 transition-colors duration-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center gap-3 text-primary-700 dark:text-primary-300">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            </div>
        </div>
        @endif

        <main class="flex-1 overflow-hidden flex flex-col">
            {{ $slot }}
        </main>
    </div>

    <button id="dark-mode-toggle" class="fixed bottom-6 left-6 w-14 h-14 rounded-full bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 flex items-center justify-center z-50 transition-all duration-300 hover:scale-110 active:scale-95">
        <svg id="sun-icon" class="w-7 h-7 text-yellow-500 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
        <svg id="moon-icon" class="w-7 h-7 text-gray-700 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const darkModeToggle = document.getElementById('dark-mode-toggle');


            function toggleDarkMode() {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('darkMode', isDark);
            }


            if (darkModeToggle) {
                darkModeToggle.addEventListener('click', toggleDarkMode);
            }
        });
    </script>
</body>

</html>