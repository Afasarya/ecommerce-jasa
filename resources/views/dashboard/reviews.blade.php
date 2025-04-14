<x-dashboard-layout>
    <x-slot name="header">Review Saya</x-slot>
    <x-slot name="title">Review Saya</x-slot>
    
    <!-- Pending Reviews -->
    @if($pendingReviews->isNotEmpty())
        <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Pesanan yang Menunggu Review</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Berikan review untuk pesanan yang telah selesai.
                </p>
            </div>
            
            <div class="divide-y divide-gray-200">
                @foreach($pendingReviews as $order)
                    @foreach($order->items as $item)
                        @if(!$item->hasBeenReviewed())
                            <div class="p-6 flex flex-col sm:flex-row">
                                <div class="sm:w-24 sm:h-24 mb-4 sm:mb-0 flex-shrink-0">
                                    @if($item->service && $item->service->getFirstMediaUrl('thumbnail'))
                                        <img src="{{ $item->service->getFirstMediaUrl('thumbnail') }}" alt="{{ $item->service_name }}" class="w-full h-full object-cover rounded">
                                    @else
                                        <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center text-gray-400">
                                            <i class="fas fa-image text-2xl"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex-1 sm:ml-6 flex flex-col">
                                    <div class="flex justify-between">
                                        <div>
                                            <h3 class="text-base font-medium text-gray-900">{{ $item->service_name }}</h3>
                                            <p class="text-sm text-gray-500">
                                                Pesanan #{{ $order->order_number }} &middot; {{ $order->completed_at ? $order->completed_at->format('d M Y') : $order->created_at->format('d M Y') }}
                                            </p>
                                        </div>
                                        
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" onclick="document.getElementById('review-modal-{{ $item->id }}').classList.remove('hidden')">
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
                                                                        <div class="rating flex space-x-2">
                                                                            @for($i = 5; $i >= 1; $i--)
                                                                                <div>
                                                                                    <input type="radio" name="rating" value="{{ $i }}" id="rating-{{ $item->id }}-{{ $i }}" class="hidden peer" {{ $i == 5 ? 'checked' : '' }}>
                                                                                    <label for="rating-{{ $item->id }}-{{ $i }}" class="cursor-pointer text-2xl text-yellow-400 peer-checked:text-yellow-400 peer-checked:font-bold">
                                                                                        <i class="fas fa-star"></i>
                                                                                    </label>
                                                                                </div>
                                                                            @endfor
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
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    @endif
    
    <!-- My Reviews -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Review Saya</h2>
            <p class="mt-1 text-sm text-gray-500">
                Ulasan yang telah Anda berikan untuk layanan kami.
            </p>
        </div>
        
        <div class="divide-y divide-gray-200">
            @forelse($userReviews as $review)
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12">
                            @if($review->service && $review->service->getFirstMediaUrl('thumbnail'))
                                <img src="{{ $review->service->getFirstMediaUrl('thumbnail') }}" alt="{{ $review->service->name }}" class="w-full h-full object-cover rounded">
                            @else
                                <div class="w-full h-full bg-gray-200 rounded flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="ml-4 flex-1">
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="text-base font-medium text-gray-900">{{ $review->service->name ?? 'Layanan tidak tersedia' }}</h3>
                                    <p class="text-sm text-gray-500">
                                        Pesanan #{{ $review->order->order_number }} &middot; {{ $review->created_at->format('d M Y') }}
                                    </p>
                                </div>
                                
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            
                            <div class="mt-2 text-gray-700">
                                {{ $review->comment ?? 'Tidak ada komentar' }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-gray-100 text-gray-400 mb-6">
                        <i class="fas fa-star text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada review</h3>
                    <p class="text-gray-500 mb-6">Anda belum memberikan ulasan untuk layanan apapun.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($userReviews->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $userReviews->links() }}
            </div>
        @endif
    </div>
</x-dashboard-layout>   