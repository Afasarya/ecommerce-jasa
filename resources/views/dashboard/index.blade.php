<x-dashboard-layout>
    <x-slot name="header">Dashboard</x-slot>
    <x-slot name="title">Dashboard</x-slot>
    
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-primary-100 rounded-full p-3">
                    <i class="fas fa-shopping-bag text-primary-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Pesanan</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ auth()->user()->orders->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 rounded-full p-3">
                    <i class="fas fa-spinner text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Pesanan Aktif</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $activeOrders }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 rounded-full p-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Pesanan Selesai</h3>
                    <p class="text-2xl font-semibold text-gray-900">{{ $completedOrders }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 rounded-full p-3">
                    <i class="fas fa-wallet text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Pengeluaran</h3>
                    <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">Pesanan Terbaru</h2>
                <a href="{{ route('dashboard.orders') }}" class="text-primary-600 hover:text-primary-800 text-sm font-medium">
                    Lihat Semua
                </a>
            </div>
        </div>
        
        <div class="divide-y divide-gray-200">
            @forelse($recentOrders as $order)
                <div class="px-6 py-4 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Nomor Pesanan</p>
                            <a href="{{ route('orders.show', $order->order_number) }}" class="font-medium text-gray-900 hover:text-primary-600">
                                {{ $order->order_number }}
                            </a>
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
                            <a href="{{ route('orders.show', $order->order_number) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center">
                    <p class="text-gray-500">Belum ada pesanan</p>
                </div>
            @endforelse
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Akses Cepat</h2>
        </div>
        
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('services.index') }}" class="group flex flex-col items-center p-6 bg-gray-50 rounded-lg hover:bg-primary-50 border border-gray-200">
                <div class="bg-white rounded-full p-3 shadow-md group-hover:bg-primary-100">
                    <i class="fas fa-search text-primary-600 text-xl"></i>
                </div>
                <h3 class="mt-4 font-medium text-gray-900 group-hover:text-primary-700">Jelajahi Layanan</h3>
                <p class="mt-1 text-sm text-gray-500 text-center group-hover:text-primary-600">Temukan layanan sesuai kebutuhan Anda</p>
            </a>
            
            <a href="{{ route('cart.index') }}" class="group flex flex-col items-center p-6 bg-gray-50 rounded-lg hover:bg-primary-50 border border-gray-200">
                <div class="bg-white rounded-full p-3 shadow-md group-hover:bg-primary-100">
                    <i class="fas fa-shopping-cart text-primary-600 text-xl"></i>
                </div>
                <h3 class="mt-4 font-medium text-gray-900 group-hover:text-primary-700">Keranjang Saya</h3>
                <p class="mt-1 text-sm text-gray-500 text-center group-hover:text-primary-600">Lihat item di keranjang belanja Anda</p>
            </a>
            
            <a href="{{ route('dashboard.orders') }}" class="group flex flex-col items-center p-6 bg-gray-50 rounded-lg hover:bg-primary-50 border border-gray-200">
                <div class="bg-white rounded-full p-3 shadow-md group-hover:bg-primary-100">
                    <i class="fas fa-shopping-bag text-primary-600 text-xl"></i>
                </div>
                <h3 class="mt-4 font-medium text-gray-900 group-hover:text-primary-700">Pesanan Saya</h3>
                <p class="mt-1 text-sm text-gray-500 text-center group-hover:text-primary-600">Kelola dan pantau status pesanan Anda</p>
            </a>
            
            <a href="{{ route('dashboard.settings') }}" class="group flex flex-col items-center p-6 bg-gray-50 rounded-lg hover:bg-primary-50 border border-gray-200">
                <div class="bg-white rounded-full p-3 shadow-md group-hover:bg-primary-100">
                    <i class="fas fa-cog text-primary-600 text-xl"></i>
                </div>
                <h3 class="mt-4 font-medium text-gray-900 group-hover:text-primary-700">Pengaturan</h3>
                <p class="mt-1 text-sm text-gray-500 text-center group-hover:text-primary-600">Perbarui profil dan preferensi Anda</p>
            </a>
        </div>
    </div>
</x-dashboard-layout>