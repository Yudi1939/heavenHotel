<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite('resources/css/app.css')
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: Karla; }
        .bg-sidebar { background: #6b21a8; }
        .hover-bg { background: #5a189a; }
        .cta-btn { color: #6b21a8; }
        .cta-btn:hover { background: #5a189a; color: #fff; }
        .nav-item:hover, .active-nav-link { background: #5a189a; }
        .account-link:hover { background: #6b21a8; color: #fff; }
    </style>
</head>
<body class="bg-gray-100 font-family-karla flex">
    <!-- Sidebar -->
    <aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
        <div class="p-6">
            <a href="index.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
        </div>
        <nav class="text-white text-base font-semibold pt-3">
            <a href="{{ route('homeAdmin') }}" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-home mr-3"></i> Home
            </a>
            <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-clipboard-list mr-3"></i> Pesanan
            </a>
            <a href="#" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
                <i class="fas fa-user-friends mr-3"></i> User
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="relative w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Header -->
        <header class="w-full flex items-center justify-between bg-white py-4 px-6 shadow-md">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('homeAdmin') }}" class="text-purple-700 text-2xl font-bold hover:text-purple-900">Heaven Hotel</a>
            </div>
        
            <!-- Filter dan Pencarian -->
            <div class="flex-grow flex items-center justify-center space-x-4">
                <!-- Form Filter -->
                <form action="{{ route('filterAdmin') }}" method="GET" class="flex items-center space-x-2">
                    <select name="filter" class="bg-gray-100 border border-gray-300 text-sm text-gray-700 py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-700">
                        <option value="" disabled selected>Pilih Filter</option>
                        <option value="5">Hotel Bintang 5</option>
                        <option value="4">Hotel Bintang 4</option>
                        <option value="3">Hotel Bintang 3</option>
                    </select>
                    <button type="submit" class="bg-purple-700 text-white py-2 text-sm px-4 rounded-md hover:bg-purple-800 flex items-center space-x-2">
                        <i class="bi bi-funnel"></i>
                        <span>Filter</span>
                    </button>
                </form>
            
                <!-- Form Search -->
                <div class="relative w-2/3 max-w-md">
                    <form action="{{ route('searchAdmin') }}" method="GET" class="relative">
                        <input type="text" name="search" 
                            placeholder="Cari..."
                            class="w-full bg-gray-100 border border-gray-300 text-sm text-gray-700 py-2 pl-4 pr-10 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-700">
                        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-purple-700">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        
            <!-- Menu Navigasi Kanan -->
            <nav class="flex items-center space-x-6">
                <!-- Dropdown untuk Profile dan Logout -->
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-purple-700 hover:bg-purple-800 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                            
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                    
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="text-white bg-purple-700 hover:bg-purple-800">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" 
                                                 class="text-white bg-purple-700 hover:bg-purple-800"
                                                 onclick="event.preventDefault();
                                                         this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </nav>
        </header>

        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <!-- Notifikasi Flash -->
                @if (session('success'))
                    <div id="success-message" class="fixed top-5 right-5 bg-green-500 text-white p-4 rounded-lg shadow-lg opacity-0 transform transition-all duration-400 ease-in-out">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div id="error-message" class="fixed top-5 right-5 bg-red-500 text-white p-4 rounded-lg shadow-lg opacity-0 transform transition-all duration-400 ease-in-out">
                        {{ session('error') }}
                    </div>
                @endif
                {{ $slot }}
            </main>
            <footer class="bg-purple-900 p-4 text-white text-center">
                <p>© 2024 Heaven Hotel. All rights reserved.</p>
            </footer>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');
            
            // Untuk pesan sukses
            if (successMessage) {
                successMessage.classList.remove('opacity-0');
                successMessage.classList.add('opacity-100');
                setTimeout(() => {
                    successMessage.classList.add('opacity-0');
                }, 2000); // Menghilangkan setelah 2 detik
            }
    
            // Untuk pesan error
            if (errorMessage) {
                errorMessage.classList.remove('opacity-0');
                errorMessage.classList.add('opacity-100');
                setTimeout(() => {
                    errorMessage.classList.add('opacity-0');
                }, 2000); // Menghilangkan setelah 2 detik
            }
        });
    </script>    
</body>
</html>