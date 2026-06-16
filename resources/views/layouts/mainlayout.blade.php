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
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <button id="sidebar-toggle-btn" class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <div class="flex-shrink-0 flex items-center ml-3">
                            <span class="text-xl font-semibold text-gray-900 dark:text-white">{{ config('app.name', 'Restaurant Management Project') }}</span>
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

                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex items-center justify-center gap-3 text-primary-700 dark:text-primary-300">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>

                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex flex-1 overflow-hidden">
            <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transform -translate-x-full transition-all duration-300 ease-in-out transition-colors duration-200">
                <div class="h-16 flex items-center justify-between px-6 border-b border-gray-200 dark:border-gray-700 lg:flex transition-colors duration-200">
                    <span class="text-lg font-semibold text-gray-900 dark:text-white">Menu</span>
                    <button id="close-sidebar-btn" class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <nav class="p-4 space-y-1">
                    <a href="{{ url('/categories') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->is('categories*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-gray-700' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                      <img src="{{asset('storage/icons/category.png')}}" alt="category.png" class="w-6 h-6 mr-3">
                        Category
                    </a>
                    <a href="{{ url('/menu') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->is('menu*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-gray-700' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <img src="{{asset('storage/icons/menu.png')}}" alt="menu.png" class="w-7 h-7 mr-3">
                        Menu
                    </a>
                      <a href="{{ url('/tables') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->is('table*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-800' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <img src="{{asset('storage/icons/table.png')}}" alt="table.png" class="w-6 h-6 mr-3">
                        Tables
                    </a>
                    <a href="{{ url('/users') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->is('users*') ? 'text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-gray-700' : 'text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                       <img src="{{asset('storage/icons/user.png')}}" alt="user.png" class="w-6 h-6 mr-3">
                        User Management
                    </a>
                </nav>
            </aside>

            <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden"></div>

            <main id="main-content" class="flex-1 overflow-auto transition-all duration-300 ml-0">
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
            const closeSidebarBtn = document.getElementById('close-sidebar-btn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const darkModeToggle = document.getElementById('dark-mode-toggle');
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            const mainContent = document.getElementById('main-content');

            // Load sidebar state from localStorage
            function loadSidebarState() {
                const isSidebarOpen = localStorage.getItem('sidebarOpen') !== 'false';
                if (isSidebarOpen) {
                    sidebar.classList.remove('-translate-x-full');
                    mainContent.classList.add('lg:ml-64');
                } else {
                    sidebar.classList.add('-translate-x-full');
                    mainContent.classList.remove('lg:ml-64');
                }
            }

            // Save sidebar state to localStorage
            function saveSidebarState(isOpen) {
                localStorage.setItem('sidebarOpen', isOpen);
            }

            // Toggle sidebar for all devices
            function toggleSidebar() {
                const isOpen = !sidebar.classList.contains('-translate-x-full');
                if (isOpen) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    mainContent.classList.remove('lg:ml-64');
                    saveSidebarState(false);
                } else {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    mainContent.classList.add('lg:ml-64');
                    saveSidebarState(true);
                }
            }

            // Close sidebar (for mobile)
            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                mainContent.classList.remove('lg:ml-64');
                saveSidebarState(false);
            }

            function toggleDarkMode() {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('darkMode', isDark);
            }

            // Initialize
            loadSidebarState();

            if (sidebarToggleBtn) {
                sidebarToggleBtn.addEventListener('click', toggleSidebar);
            }

            if (closeSidebarBtn) {
                closeSidebarBtn.addEventListener('click', closeSidebar);
            }

            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }

            if (darkModeToggle) {
                darkModeToggle.addEventListener('click', toggleDarkMode);
            }

            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 1024) {
                        closeSidebar();
                    }
                });
            });
        });
    </script>
</body>
</html>