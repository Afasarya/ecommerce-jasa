<x-app-layout>
    <x-slot name="title">Pesanan Saya</x-slot>
    
    <!-- Hero Section -->
    <section class="bg-primary-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Pesanan Saya</h1>
                <p class="text-xl text-primary-100 max-w-3xl mx-auto">
                    Kelola dan pantau status pesanan layanan Anda
                </p>
            </div>
        </div>
    </section>
    
    <!-- Orders Content -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button class="tab-btn text-primary-600 border-primary-500 inline-flex items-center px-4 py-4 border-b-2 text-sm font-medium" data-tab="all">
                            Semua
                        </button>
                        <button class="tab-btn text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-4 py-4 border-b-2 text-sm font-medium" data-tab="pending">
                            Menunggu Pembayaran
                        </button>
                        <button class="tab-btn text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-4 py-4 border-b-2 text-sm font-medium" data-tab="processing">
                            Diproses
                        </button>
                        <button class="tab-btn text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-4 py-4 border-b-2 text-sm font-medium" data-tab="completed">
                            Selesai
                        </button>
                        <button class="tab-btn text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300 inline-flex items-center px-4 py-4 border-b-2 text-sm font-medium" data-tab="cancelled">
                            Dibatalkan
                        </button>
                    </nav>
                </div>
                
                <!-- Tab Content -->
                <div class="divide-y divide-gray-200">
                    <!-- All Orders Tab -->
                    <div id="tab-all" class="tab-content block">
                        @if($orders->count() > 0)
                            @foreach($orders as $order)
                                <div class="p-6 hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-500">Nomor Pesanan</p>
                                            <p class="font-medium text-gray-900">{{ $order->order_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Tanggal</p>
                                            <p class="text-sm text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Total</p>
                                            <p class="font-medium text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Status</p>
                                            @if($order->status == 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Menunggu
                                                </span>
                                            @elseif($order->status == 'processing')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Diproses
                                                </span>
                                            @elseif($order->status == 'completed')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Selesai
                                                </span>
                                            @elseif($order->status == 'cancelled')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Dibatalkan
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Pembayaran</p>
                                            @if($order->transaction)
                                                @if($order->transaction->status == 'pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Menunggu
                                                    </span>
                                                @elseif($order->transaction->status == 'success')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Sukses
                                                    </span>
                                                @elseif($order->transaction->status == 'failed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Gagal
                                                    </span>
                                                @elseif($order->transaction->status == 'expired')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Kadaluarsa
                                                    </span>
                                                @elseif($order->transaction->status == 'refunded')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        Dikembalikan
                                                    </span>
                                                @endif
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    -
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('orders.show', $order->order_number) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="py-12 text-center">
                                <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-gray-100 text-gray-400 mb-6">
                                    <i class="fas fa-shopping-bag text-4xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pesanan</h3>
                                <p class="text-gray-500 mb-6">Anda belum melakukan pesanan apapun</p>
                                <a href="{{ route('services.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Jelajahi Layanan
                                </a>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Pending Orders Tab -->
                    <div id="tab-pending" class="tab-content hidden">
                        @if($orders->where('status', 'pending')->count() > 0)
                            @foreach($orders->where('status', 'pending') as $order)
                                <div class="p-6 hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-500">Nomor Pesanan</p>
                                            <p class="font-medium text-gray-900">{{ $order->order_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Tanggal</p>
                                            <p class="text-sm text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Total</p>
                                            <p class="font-medium text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Pembayaran</p>
                                            @if($order->transaction)
                                                @if($order->transaction->status == 'pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        Menunggu
                                                    </span>
                                                @elseif($order->transaction->status == 'success')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Sukses
                                                    </span>
                                                @elseif($order->transaction->status == 'failed')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Gagal
                                                    </span>
                                                @endif
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    -
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('orders.show', $order->order_number) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="py-12 text-center">
                                <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-gray-100 text-gray-400 mb-6">
                                    <i class="fas fa-clock text-4xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pesanan menunggu</h3>
                                <p class="text-gray-500 mb-6">Anda tidak memiliki pesanan yang menunggu pembayaran</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Processing Orders Tab -->
                    <div id="tab-processing" class="tab-content hidden">
                        @if($orders->where('status', 'processing')->count() > 0)
                            @foreach($orders->where('status', 'processing') as $order)
                                <div class="p-6 hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-500">Nomor Pesanan</p>
                                            <p class="font-medium text-gray-900">{{ $order->order_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Tanggal</p>
                                            <p class="text-sm text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Total</p>
                                            <p class="font-medium text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                        </div>
                                        <div>
                                            <a href="{{ route('orders.show', $order->order_number) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="py-12 text-center">
                                <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-gray-100 text-gray-400 mb-6">
                                    <i class="fas fa-spinner text-4xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pesanan diproses</h3>
                                <p class="text-gray-500 mb-6">Anda tidak memiliki pesanan yang sedang diproses</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Completed Orders Tab -->
                    <div id="tab-completed" class="tab-content hidden">
                        @if($orders->where('status', 'completed')->count() > 0)
                            @foreach($orders->where('status', 'completed') as $order)
                                <div class="p-6 hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-500">Nomor Pesanan</p>
                                            <p class="font-medium text-gray-900">{{ $order->order_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Tanggal</p>
                                            <p class="text-sm text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Selesai</p>
                                            <p class="text-sm text-gray-900">{{ $order->completed_at ? $order->completed_at->format('d M Y, H:i') : '-' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Total</p>
                                            <p class="font-medium text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                        </div>
                                        <div>
                                            <a href="{{ route('orders.show', $order->order_number) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="py-12 text-center">
                                <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-gray-100 text-gray-400 mb-6">
                                    <i class="fas fa-check-circle text-4xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pesanan selesai</h3>
                                <p class="text-gray-500 mb-6">Anda belum memiliki pesanan yang telah selesai</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Cancelled Orders Tab -->
                    <div id="tab-cancelled" class="tab-content hidden">
                        @if($orders->where('status', 'cancelled')->count() > 0)
                            @foreach($orders->where('status', 'cancelled') as $order)
                                <div class="p-6 hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-500">Nomor Pesanan</p>
                                            <p class="font-medium text-gray-900">{{ $order->order_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Tanggal</p>
                                            <p class="text-sm text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Total</p>
                                            <p class="font-medium text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                        </div>
                                        <div>
                                            <a href="{{ route('orders.show', $order->order_number) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="py-12 text-center">
                                <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-gray-100 text-gray-400 mb-6">
                                    <i class="fas fa-times-circle text-4xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pesanan dibatalkan</h3>
                                <p class="text-gray-500 mb-6">Anda tidak memiliki pesanan yang dibatalkan</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Pagination -->
                @if($orders->count() > 0)
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Remove active class from all buttons
                    tabBtns.forEach(b => {
                        b.classList.remove('text-primary-600', 'border-primary-500');
                        b.classList.add('text-gray-500', 'border-transparent');
                    });
                    
                    // Add active class to clicked button
                    btn.classList.remove('text-gray-500', 'border-transparent');
                    btn.classList.add('text-primary-600', 'border-primary-500');
                    
                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    
                    // Show selected tab content
                    const tabId = btn.dataset.tab;
                    document.getElementById(`tab-${tabId}`).classList.remove('hidden');
                });
            });
        });
    </script>
    @endpush
</x-app-layout>