<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <span class="text-primary-500 font-bold text-2xl">Code<span class="text-gray-800">Craft</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:ms-10 sm:flex">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'border-b-2 border-primary-500 text-primary-600' : 'text-gray-500 hover:text-primary-500' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                        {{ __('Beranda') }}
                    </a>
                    <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'border-b-2 border-primary-500 text-primary-600' : 'text-gray-500 hover:text-primary-500' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                        {{ __('Layanan') }}
                    </a>
                    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'border-b-2 border-primary-500 text-primary-600' : 'text-gray-500 hover:text-primary-500' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                        {{ __('Tentang Kami') }}
                    </a>
                    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'border-b-2 border-primary-500 text-primary-600' : 'text-gray-500 hover:text-primary-500' }} inline-flex items-center px-1 pt-1 text-sm font-medium">
                        {{ __('Kontak') }}
                    </a>
                </div>
            </div>

            <div class="flex items-center">
                <!-- Cart -->
                @auth
                    <a href="{{ route('cart.index') }}" class="relative inline-flex items-center mx-2 text-gray-500 hover:text-primary-500 focus:outline-none transition">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        @if(auth()->user()->cart && auth()->user()->cart->item_count > 0)
                            <span class="absolute -top-2 -right-2 bg-primary-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                {{ auth()->user()->cart->item_count }}
                            </span>
                        @endif
                    </a>
                @endauth

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('dashboard.index')">
                                    {{ __('Dashboard') }}
                                </x-dropdown-link>
                                
                                <x-dropdown-link :href="route('dashboard.orders')">
                                    {{ __('Pesanan Saya') }}
                                </x-dropdown-link>
                                
                                <x-dropdown-link :href="route('dashboard.reviews')">
                                    {{ __('Review Saya') }}
                                </x-dropdown-link>
                                
                                <x-dropdown-link :href="route('dashboard.settings')">
                                    {{ __('Pengaturan') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Keluar') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-primary-500 px-3 py-2 text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="ml-2 inline-flex items-center justify-center px-4 py-2 bg-primary-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-600 active:bg-primary-700 focus:outline-none focus:border-primary-700 focus:ring focus:ring-primary-300 disabled:opacity-25 transition">Register</a>
                    @endauth
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Beranda') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('services.index')" :active="request()->routeIs('services.*')">
                {{ __('Layanan') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')">
                {{ __('Tentang Kami') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')">
                {{ __('Kontak') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('dashboard.index')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('dashboard.orders')">
                        {{ __('Pesanan Saya') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('dashboard.reviews')">
                        {{ __('Review Saya') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('dashboard.settings')">
                        {{ __('Pengaturan') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('cart.index')">
                        {{ __('Keranjang') }}
                        @if(auth()->user()->cart && auth()->user()->cart->item_count > 0)
                            <span class="ml-2 bg-primary-500 text-white rounded-full w-5 h-5 inline-flex items-center justify-center text-xs">
                                {{ auth()->user()->cart->item_count }}
                            </span>
                        @endif
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Keluar') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        @endauth
    </div>
</nav>
