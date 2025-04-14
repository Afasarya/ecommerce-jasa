<x-app-layout>
    <x-slot name="title">Detail Pesanan</x-slot>
    
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
                        <a href="{{ route('dashboard.orders') }}" class="text-gray-500 hover:text-primary-600">Pesanan Saya</a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-1"></i>
                        <span class="text-gray-700" aria-current="page">{{ $order->order_number }}</span>
                    </li>
                </ol>
            </nav>
        </div>
    </section>
    
    <!-- Order Details -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">Detail Pesanan</h1>
                <a href="{{ route('dashboard.orders') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Kembali ke daftar pesanan
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Order Info -->
                <div class="md:col-span-2">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h2 class="text-lg font-semibold text-gray-900">Informasi Pesanan</h2>
                                <div>
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
                            </div>
                            
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Nomor Pesanan</p>
                                    <p class="font-medium text-gray-900">{{ $order->order_number }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal Pemesanan</p>
                                    <p class="font-medium text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Total Pembayaran</p>
                                    <p class="font-medium text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Status Pembayaran</p>
                                    <p class="font-medium">
                                        @if($order->transaction)
                                            @if($order->transaction->status == 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Menunggu Pembayaran
                                                </span>
                                            @elseif($order->transaction->status == 'success')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Pembayaran Berhasil
                                                </span>
                                            @elseif($order->transaction->status == 'failed')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Pembayaran Gagal
                                                </span>
                                            @elseif($order->transaction->status == 'expired')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Pembayaran Kadaluarsa
                                                </span>
                                            @elseif($order->transaction->status == 'refunded')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Dana Dikembalikan
                                                </span>
                                            @endif
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Belum Ada Pembayaran
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            @if($order->notes)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <p class="text-sm text-gray-500">Catatan</p>
                                    <p class="text-gray-700">{{ $order->notes }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-6">
                            <h3 class="font-semibold text-gray-900 mb-4">Item Pesanan</h3>
                            
                            <div class="divide-y divide-gray-200">
                                @foreach($order->items as $item)
                                    <div class="py-4 flex items-start">
                                        <div class="flex-shrink-0 w-16 h-16">
                                            @if($item->service && $item->service->getFirstMediaUrl('thumbnail'))
                                                <img src="{{ $item->service->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->service_name }}" class="w-full h-full object-cover rounded">
                                            @else
                                                <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center text-gray-400">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <div class="flex justify-between">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $item->service_name }}</h4>
                                                <p class="text-sm font-medium text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                            </div>
                                            <div class="mt-1 flex justify-between text-sm">
                                                <div class="text-gray-500">
                                                    <span>Jumlah: {{ $item->quantity }}</span>
                                                    <span class="mx-1">·</span>
                                                    <span>Rp {{ number_format($item->price, 0, ',', '.') }} per item</span>
                                                </div>
                                                
                                                @if($order->status === 'completed' && !$item->hasBeenReviewed())
                                                    <button type="button" class="text-primary-600 hover:text-primary-700 font-medium" onclick="document.getElementById('review-modal-{{ $item->id }}').classList.remove('hidden')">
                                                        Beri Ulasan
                                                    </button>
                                                    
                                                    <!-- Review Modal -->
                                                    <div id="review-modal-{{ $item->id }}" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
                                                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                                <form action="{{ route('reviews.store') }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                                    <input type="hidden" name="service_id" value="{{ $item->service_id }}">
                                                                    
                                                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                                        <div class="sm:flex sm:items-start">
                                                                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                                                                    Beri Ulasan untuk "{{ $item->service_name }}"
                                                                                </h3>
                                                                                
                                                                                <div class="mb-4">
                                                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                                                                    <div class="flex space-x-2">
                                                                                        <div class="rating">
                                                                                            @for($i = 5; $i >= 1; $i--)
                                                                                                <input type="radio" name="rating" value="{{ $i }}" id="rating-{{ $item->id }}-{{ $i }}" class="hidden" {{ $i == 5 ? 'checked' : '' }}>
                                                                                                <label for="rating-{{ $item->id }}-{{ $i }}" class="cursor-pointer text-2xl">
                                                                                                    <i class="far fa-star text-yellow-400 peer-checked:fas"></i>
                                                                                                </label>
                                                                                            @endfor
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div>
                                                                                    <label for="comment-{{ $item->id }}" class="block text-sm font-medium text-gray-700 mb-2">Komentar</label>
                                                                                    <textarea id="comment-{{ $item->id }}" name="comment" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Bagikan pengalaman Anda dengan layanan ini..."></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                                            Kirim Ulasan
                                                                        </button>
                                                                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="document.getElementById('review-modal-{{ $item->id }}').classList.add('hidden')">
                                                                            Batal
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            @if($item->notes)
                                                <div class="mt-1 text-sm text-gray-600">
                                                    <span class="font-medium">Catatan:</span> {{ $item->notes }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Status -->
                <div>
                    <div class="bg-white shadow-md rounded-lg overflow-hidden sticky top-20">
                        <div class="p-6 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Status Pesanan</h2>
                            
                            <div class="space-y-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        @if($order->created_at)
                                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center">
                                                <i class="fas fa-check text-white"></i>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-circle text-gray-400 text-xs"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium {{ $order->created_at ? 'text-gray-900' : 'text-gray-500' }}">Pesanan Dibuat</h3>
                                        @if($order->created_at)
                                            <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        @if($order->transaction && $order->transaction->status == 'success')
                                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center">
                                                <i class="fas fa-check text-white"></i>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 rounded-full {{ $order->transaction ? 'bg-yellow-500' : 'bg-gray-200' }} flex items-center justify-center">
                                                <i class="fas {{ $order->transaction ? 'fa-clock text-white' : 'fa-circle text-gray-400 text-xs' }}"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium {{ $order->transaction ? 'text-gray-900' : 'text-gray-500' }}">Pembayaran</h3>
                                        @if($order->transaction)
                                            @if($order->transaction->status == 'success')
                                                <p class="text-xs text-gray-500">Pembayaran berhasil pada {{ $order->transaction->paid_at->format('d M Y, H:i') }}</p>
                                            @elseif($order->transaction->status == 'pending')
                                                <p class="text-xs text-gray-500">Menunggu pembayaran</p>
                                            @else
                                                <p class="text-xs text-gray-500">Pembayaran {{ $order->transaction->status }}</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        @if($order->status == 'processing')
                                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center">
                                                <i class="fas fa-check text-white"></i>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-circle text-gray-400 text-xs"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium {{ $order->status == 'processing' || $order->status == 'completed' ? 'text-gray-900' : 'text-gray-500' }}">Diproses</h3>
                                        @if($order->status == 'processing' || $order->status == 'completed')
                                            <p class="text-xs text-gray-500">Pesanan sedang dikerjakan</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        @if($order->status == 'completed')
                                            <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center">
                                                <i class="fas fa-check text-white"></i>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-circle text-gray-400 text-xs"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium {{ $order->status == 'completed' ? 'text-gray-900' : 'text-gray-500' }}">Selesai</h3>
                                        @if($order->status == 'completed')
                                            <p class="text-xs text-gray-500">Pesanan selesai pada {{ $order->completed_at->format('d M Y, H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            @if($order->transaction && $order->transaction->status == 'pending')
                                <a href="{{ route('transaction.pay', $order->transaction->id) }}" class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Lanjutkan Pembayaran
                                </a>
                            @endif
                            
                            <a href="{{ route('dashboard.orders') }}" class="mt-3 w-full flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Lihat Semua Pesanan
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
            // Rating stars
            const stars = document.querySelectorAll('.rating label');
            
            stars.forEach((star, index) => {
                star.addEventListener('click', () => {
                    stars.forEach((s, i) => {
                        if (i <= index) {
                            s.querySelector('i').classList.remove('far');
                            s.querySelector('i').classList.add('fas');
                        } else {
                            s.querySelector('i').classList.remove('fas');
                            s.querySelector('i').classList.add('far');
                        }
                    });
                });
            });
        });
    </script>
    @endpush
</x-app-layout>