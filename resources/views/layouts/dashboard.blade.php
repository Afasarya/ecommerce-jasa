<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CodeCraft') }} - Dashboard {{ $title ?? '' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <!-- Styles -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <div class="flex">
            <!-- Sidebar -->
            <aside x-data="{ open: window.innerWidth >= 768 }" x-init="window.addEventListener('resize', () => { open = window.innerWidth >= 768 })" :class="{'w-64': open, 'w-16': !open}" class="bg-gray-800 text-white min-h-screen transition-all duration-300">
                <div class="p-4 flex flex-col h-full">
                    <button @click="open = !open" class="self-end md:hidden text-white mb-6">
                        <i class="fas" :class="{'fa-arrow-right': !open, 'fa-arrow-left': open}"></i>
                    </button>
                    
                    <nav class="space-y-1">
                        <a href="{{ route('dashboard.index') }}" class="{{ request()->routeIs('dashboard.index') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-home mr-3 text-lg"></i>
                            <span x-show="open">Dashboard</span>
                        </a>
                        
                        <a href="{{ route('dashboard.orders') }}" class="{{ request()->routeIs('dashboard.orders') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-shopping-bag mr-3 text-lg"></i>
                            <span x-show="open">Pesanan Saya</span>
                        </a>
                        
                        <a href="{{ route('dashboard.reviews') }}" class="{{ request()->routeIs('dashboard.reviews') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-star mr-3 text-lg"></i>
                            <span x-show="open">Review Saya</span>
                        </a>
                        
                        <a href="{{ route('dashboard.settings') }}" class="{{ request()->routeIs('dashboard.settings') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-cog mr-3 text-lg"></i>
                            <span x-show="open">Pengaturan</span>
                        </a>
                        
                        <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'bg-primary-600 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-shopping-cart mr-3 text-lg"></i>
                            <span x-show="open">Keranjang Saya</span>
                            @if(auth()->user()->cart && auth()->user()->cart->item_count > 0)
                                <span x-show="open" class="ml-auto bg-primary-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                    {{ auth()->user()->cart->item_count }}
                                </span>
                            @endif
                        </a>
                        
                        <a href="{{ route('services.index') }}" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <i class="fas fa-list mr-3 text-lg"></i>
                            <span x-show="open">Lihat Layanan</span>
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="mt-6">
                            @csrf
                            <button type="submit" class="w-full text-left text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                <i class="fas fa-sign-out-alt mr-3 text-lg"></i>
                                <span x-show="open">Keluar</span>
                            </button>
                        </form>
                    </nav>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col">
                <!-- Page Header -->
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <h1 class="text-2xl font-semibold text-gray-800">{{ $header ?? 'Dashboard' }}</h1>
                    </div>
                </header>

                <!-- Flash Messages -->
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <div class="-mx-1.5 -my-1.5">
                                        <button @click="show = false" class="text-green-500 hover:text-green-700 focus:outline-none">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 7000)" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                                </div>
                                <div class="ml-auto pl-3">
                                    <div class="-mx-1.5 -my-1.5">
                                        <button @click="show = false" class="text-red-500 hover:text-red-700 focus:outline-none">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Main Content -->
                <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>
    
    @livewireScripts
    @stack('scripts')
</body>
</html>