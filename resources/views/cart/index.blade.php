<x-app-layout>
    <x-slot name="title">Keranjang</x-slot>
    
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
                        <span class="text-gray-700" aria-current="page">Keranjang</span>
                    </li>
                </ol>
            </nav>
        </div>
    </section>
    
    <!-- Cart Content -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-8">Keranjang Belanja</h1>
            
            @if($cart && $cart->items->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="md:col-span-2">
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                                <h2 class="text-lg font-semibold text-gray-900">Item ({{ $cart->items->sum('quantity') }})</h2>
                                <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        <i class="fas fa-trash-alt mr-1"></i>
                                        Kosongkan Keranjang
                                    </button>
                                </form>
                            </div>
                            
                            <div class="divide-y divide-gray-200">
                                @foreach($cart->items as $item)
                                    <div class="p-6 flex flex-col sm:flex-row">
                                        <!-- Service Image -->
                                        <div class="sm:w-24 sm:h-24 mb-4 sm:mb-0 flex-shrink-0">
                                            @if($item->service->getFirstMediaUrl('thumbnail'))
                                                <img src="{{ $item->service->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->service->name }}" class="w-full h-full object-cover rounded">
                                            @else
                                                <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center text-gray-400">
                                                    <i class="fas fa-image text-2xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Service Details -->
                                        <div class="flex-1 sm:ml-6 flex flex-col">
                                            <div class="flex justify-between">
                                                <h3 class="text-base font-medium text-gray-900">
                                                    <a href="{{ route('services.show', $item->service->slug) }}" class="hover:text-primary-600">
                                                        {{ $item->service->name }}
                                                    </a>
                                                </h3>
                                                <div class="text-primary-600 font-semibold">
                                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                                </div>
                                            </div>
                                            
                                            <div class="text-sm text-gray-500 mb-4">
                                                {{ Str::limit($item->service->short_description, 100) }}
                                            </div>
                                            
                                            @if($item->notes)
                                                <div class="text-sm text-gray-700 mb-4">
                                                    <strong>Catatan:</strong> {{ $item->notes }}
                                                </div>
                                            @endif
                                            
                                            <div class="mt-auto flex justify-between items-center">
                                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <label for="quantity-{{ $item->id }}" class="sr-only">Jumlah</label>
                                                    <div class="flex items-center border border-gray-300 rounded">
                                                        <button type="button" class="quantity-btn minus px-3 py-1 text-gray-600 hover:bg-gray-100" data-input="quantity-{{ $item->id }}">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input type="number" id="quantity-{{ $item->id }}" name="quantity" min="1" value="{{ $item->quantity }}" class="p-0 w-12 text-center border-0 focus:ring-0">
                                                        <button type="button" class="quantity-btn plus px-3 py-1 text-gray-600 hover:bg-gray-100" data-input="quantity-{{ $item->id }}">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <button type="submit" class="ml-2 text-primary-600 hover:text-primary-700 text-sm font-medium">
                                                        Update
                                                    </button>
                                                </form>
                                                
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                        <i class="fas fa-trash-alt mr-1"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Summary -->
                    <div>
                        <div class="bg-white shadow-md rounded-lg overflow-hidden sticky top-20">
                            <div class="p-6 border-b border-gray-200">
                                <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                                
                                <div class="space-y-3">
                                    <div class="flex justify-between text-gray-600">
                                        <span>Subtotal ({{ $cart->items->sum('quantity') }} item)</span>
                                        <span>Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-gray-600">
                                        <span>Biaya Layanan</span>
                                        <span>Rp 0</span>
                                    </div>
                                </div>
                                
                                <div class="my-4 border-t border-gray-200 pt-3">
                                    <div class="flex justify-between font-semibold text-lg">
                                        <span>Total</span>
                                        <span class="text-primary-600">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <a href="{{ route('checkout') }}" class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Lanjut ke Checkout
                                </a>
                                
                                <a href="{{ route('services.index') }}" class="mt-3 w-full flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Lanjut Belanja
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white shadow-md rounded-lg overflow-hidden py-12 text-center">
                    <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-gray-100 text-gray-400 mb-6">
                        <i class="fas fa-shopping-cart text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Keranjang Anda Kosong</h3>
                    <p class="text-gray-500 mb-6">Anda belum menambahkan layanan apapun ke keranjang</p>
                    <a href="{{ route('services.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        Jelajahi Layanan
                    </a>
                </div>
            @endif
        </div>
    </section>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quantity buttons
            const minusButtons = document.querySelectorAll('.quantity-btn.minus');
            const plusButtons = document.querySelectorAll('.quantity-btn.plus');
            
            minusButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const input = document.getElementById(this.dataset.input);
                    const value = parseInt(input.value);
                    if (value > 1) {
                        input.value = value - 1;
                    }
                });
            });
            
            plusButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const input = document.getElementById(this.dataset.input);
                    const value = parseInt(input.value);
                    input.value = value + 1;
                });
            });
        });
    </script>
    @endpush
</x-app-layout>