<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Restaurant Management Project') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
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
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-200 min-h-screen flex items-center justify-center px-4 py-8" id="login-layout">
        <div class="w-full sm:max-w-md bg-white/90 dark:bg-gray-800/90 backdrop-blur-md shadow-2xl overflow-hidden rounded-2xl border border-white/20 dark:border-gray-700/50 transition-all duration-200">
            {{ $slot }}
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
            document.addEventListener('DOMContentLoaded', function () {
                const darkModeToggle = document.getElementById('dark-mode-toggle');
                
                function toggleDarkMode() {
                    const isDark = document.documentElement.classList.contains('dark');
                    if (isDark) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('darkMode', 'false');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('darkMode', 'true');
                    }
                }

                if (darkModeToggle) {
                    darkModeToggle.addEventListener('click', toggleDarkMode);
                }
            });
        </script>
    </body>
</html>
