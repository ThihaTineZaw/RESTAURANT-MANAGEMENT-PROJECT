<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Restaurant Management Project') }}</title>
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
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-200 min-h-screen flex items-center justify-center px-4 py-8">
    <div class="login-layout fixed z-1">

    </div>
    <div class="z-10">
        <div class="w-full sm:max-w-md  shadow-xl overflow-hidden rounded-2xl border border-gray-200/20 dark:border-gray-700/20 transition-colors duration-200 ">
        {{ $slot }}
    </div>

  
    </div>


</body>
</html>