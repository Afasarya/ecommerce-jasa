<x-app-layout>
    <x-slot name="title">Checkout</x-slot>
    
    <!-- Breadcrumbs -->
    <section class="bg-gray-50 py-4 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary-600">
                            <i class="fas fa-home"></i>
                            <span class="sr-only">Home</span>
                        </a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-1"></i>
                        <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-primary-600">Keranjang</a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-1"></i>
                        <span class="text-gray-700" aria-current="page">Checkout</span>
                    </li>
                </ol>
            </nav>
        </div>
    </section>
    
    <!-- Checkout Content -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-8">Checkout</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="md:col-span-2">
                    <form id="checkout-form" action="{{ route('orders.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Customer Details -->
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pelanggan</h2>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                        <input type="text" name="name" id="name" value="{{ auth()->user()->name }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" readonly>
                                    </div>
                                    
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" readonly>
                                    </div>
                                    
                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                                        <input type="tel" name="phone" id="phone" value="{{ auth()->user()->phone }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Notes -->
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <div class="p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Catatan Pesanan</h2>
                                
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (opsional)</label>
                                    <textarea name="notes" id="notes" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Tambahkan catatan atau instruksi khusus untuk pesanan Anda..."></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Payment Method -->
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <div class="p-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Metode Pembayaran</h2>
                                
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input id="payment-midtrans" name="payment_method" type="radio" value="midtrans" checked class="h-4 w-4 text-primary-600 border-gray-300 focus:ring-primary-500">
                                        <label for="payment-midtrans" class="ml-3 block text-sm font-medium text-gray-700">
                                            Payment Gateway (Credit Card, Bank Transfer, E-Wallet)
                                        </label>
                                    </div>
                                    
                                    <div class="ml-7 mt-2 flex flex-wrap gap-4">
                                        <div class="border rounded px-3 py-2">
                                            <img src="https://via.placeholder.com/60x30?text=VISA" alt="Visa" class="h-6">
                                        </div>
                                        <div class="border rounded px-3 py-2">
                                            <img src="https://via.placeholder.com/60x30?text=MC" alt="MasterCard" class="h-6">
                                        </div>
                                        <div class="border rounded px-3 py-2">
                                            <img src="https://via.placeholder.com/60x30?text=BCA" alt="BCA" class="h-6">
                                        </div>
                                        <div class="border rounded px-3 py-2">
                                            <img src="https://via.placeholder.com/60x30?text=BNI" alt="BNI" class="h-6">
                                        </div>
                                        <div class="border rounded px-3 py-2">
                                            <img src="https://via.placeholder.com/60x30?text=OVO" alt="OVO" class="h-6">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Submit Button (Mobile) -->
                        <div class="block md:hidden">
                            <button type="submit" class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Buat Pesanan
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Order Summary -->
                <div>
                    <div class="bg-white shadow-md rounded-lg overflow-hidden sticky top-20">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                            
                            <div class="space-y-4">
                                @php
                                    $cart = auth()->user()->cart;
                                @endphp
                                
                                @foreach($cart->items as $item)
                                    <div class="flex">
                                        <div class="flex-shrink-0 w-16 h-16 overflow-hidden rounded">
                                            @if($item->service->getFirstMediaUrl('thumbnail'))
                                                <img src="{{ $item->service->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->service->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h3 class="text-sm font-medium text-gray-900">{{ $item->service->name }}</h3>
                                            <p class="text-sm text-gray-500">Jumlah: {{ $item->quantity }}</p>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                    </div>
                                @endforeach
                                
                                <div class="border-t border-gray-200 pt-4 space-y-2">
                                    <div class="flex justify-between text-gray-600">
                                        <span>Subtotal ({{ $cart->items->sum('quantity') }} item)</span>
                                        <span>Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-gray-600">
                                        <span>Biaya Layanan</span>
                                        <span>Rp 0</span>
                                    </div>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between font-semibold text-lg">
                                        <span>Total</span>
                                        <span class="text-primary-600">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <button type="submit" form="checkout-form" class="hidden md:flex w-full items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Buat Pesanan
                            </button>
                            
                            <a href="{{ route('cart.index') }}" class="mt-3 flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Kembali ke Keranjang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add any checkout page specific JavaScript here
        });
    </script>
    @endpush
</x-app-layout>