<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heaven Hotel</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="bg-purple-100 text-purple-900">
    <!-- Navbar -->
    <nav class="bg-purple-700 p-4 shadow-lg text-white">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="{{ route('homeUser') }}" class="text-2xl font-bold">Heaven Hotel</a>
            <div class="flex items-center space-x-6"> <!-- Sejajarkan tombol menu dengan dropdown -->
                <!-- Filter dan Pencarian -->
                <div class="flex-grow flex items-center justify-center space-x-4">
                    <!-- Form Filter -->
                    <form action="{{ route('filterUser') }}" method="GET" class="flex items-center space-x-2">
                        <select name="filter" class="bg-gray-100 border border-gray-300 text-sm text-gray-700 py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-700">
                            <option value="" disabled selected>Pilih Filter</option>
                            <option value="5">Hotel Bintang 5</option>
                            <option value="4">Hotel Bintang 4</option>
                            <option value="3">Hotel Bintang 3</option>
                        </select>
                        <button type="submit" class="bg-purple-900 text-white py-2 text-sm px-4 rounded-md hover:bg-purple-800 flex items-center space-x-2">
                            <i class="bi bi-funnel"></i>
                            <span>Filter</span>
                        </button>
                    </form>
                
                    <!-- Form Search -->
                    <div class="relative w-2/3 max-w-md">
                        <form action="{{ route('searchUser') }}" method="GET" class="relative">
                            <input type="text" name="search" 
                                placeholder="Cari..."
                                class="w-full bg-gray-100 border border-gray-300 text-sm text-gray-700 py-2 pl-4 pr-10 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-700">
                            <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-purple-700">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <a href="{{ route('homeUser') }}" class="hover:underline">Home</a>
                <a href="#" class="hover:underline">Chart</a>
                <a href="{{ route('ordersUser') }}" class="hover:underline">Orders</a>
                <a href="#" class="hover:underline">History</a>


                <!-- Menu Navigasi Kanan -->
                <nav class="flex items-center space-x-6">
                    <!-- Dropdown untuk Profile dan Logout -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
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
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="w-full p-6 items-center justify-center">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-purple-700 p-4 text-white text-center mt-8">
        <p>© 2024 Heaven Hotel. All rights reserved.</p>
    </footer>
</body>
</html>