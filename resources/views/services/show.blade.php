<x-app-layout>
    <x-slot name="title">{{ $service->name }}</x-slot>
    
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
                        <a href="{{ route('services.index') }}" class="text-gray-500 hover:text-primary-600">Layanan</a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-1"></i>
                        <a href="{{ route('services.category', $service->category->slug) }}" class="text-gray-500 hover:text-primary-600">{{ $service->category->name }}</a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-1"></i>
                        <span class="text-gray-700" aria-current="page">{{ $service->name }}</span>
                    </li>
                </ol>
            </nav>
        </div>
    </section>
    
    <!-- Service Detail -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Left Column - Images -->
                <div class="md:col-span-2">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <!-- Main Image -->
                        <div class="relative">
                            @if($service->getFirstMediaUrl('thumbnail'))
                                <img src="{{ $service->getFirstMediaUrl('thumbnail') }}" alt="{{ $service->name }}" class="w-full h-96 object-cover">
                            @else
                                <div class="w-full h-96 bg-gray-300 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-6xl"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Gallery -->
                        @if($service->getMedia('gallery')->count() > 0)
                            <div class="p-4 grid grid-cols-4 gap-2">
                                @foreach($service->getMedia('gallery') as $image)
                                    <div class="relative aspect-w-1 aspect-h-1">
                                        <img src="{{ $image->getUrl() }}" alt="{{ $service->name }}" class="w-full h-24 object-cover rounded cursor-pointer hover:opacity-80 transition-opacity">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        
                        <!-- Service Description -->
                        <div class="p-6">
                            <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $service->name }}</h1>
                            
                            <div class="flex items-center mb-4">
                                <div class="flex text-yellow-400 mr-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= round($service->average_rating))
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-gray-600">{{ number_format($service->average_rating, 1) }} ({{ $service->reviews->count() }} reviews)</span>
                            </div>
                            
                            <div class="text-gray-700 mb-6">
                                <h3 class="text-lg font-semibold mb-2">Deskripsi</h3>
                                <div class="prose max-w-none">
                                    {!! $service->description !!}
                                </div>
                            </div>
                            
                            @if(is_array($service->what_you_get) && count($service->what_you_get) > 0)
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Yang Anda Dapatkan</h3>
                                    <ul class="space-y-2">
                                        @foreach($service->what_you_get as $item)
                                            <li class="flex items-start">
                                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                                <span>{{ $item['item'] }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Reviews Section -->
                    <div class="mt-8 bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Ulasan Klien</h3>
                            
                            @if($service->reviews->count() > 0)
                                <div class="space-y-6">
                                    @foreach($service->reviews as $review)
                                        <div class="border-b border-gray-200 pb-6 last:border-b-0 last:pb-0">
                                            <div class="flex justify-between items-start">
                                                <div class="flex items-start">
                                                    <div class="mr-4 w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-semibold text-gray-900">{{ $review->user->name }}</h4>
                                                        <div class="flex text-yellow-400 mt-1">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                @if($i <= $review->rating)
                                                                    <i class="fas fa-star"></i>
                                                                @else
                                                                    <i class="far fa-star"></i>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $review->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                            <div class="mt-3 text-gray-700">
                                                {{ $review->comment }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="text-gray-500 mb-4">Belum ada ulasan untuk layanan ini</div>
                                    <p class="text-sm text-gray-600">Jadilah yang pertama memberikan ulasan!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Order Box -->
                <div>
                    <div class="bg-white shadow-md rounded-lg overflow-hidden sticky top-20">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Layanan</h3>
                            
                            <div class="mb-6">
                                <div class="text-gray-700 mb-2">Harga</div>
                                <div class="text-2xl font-bold text-primary-600">
                                    @if($service->discounted_price)
                                        <span class="line-through text-gray-400 text-sm">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                        <span>Rp {{ number_format($service->discounted_price, 0, ',', '.') }}</span>
                                    @else
                                        <span>Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mb-6">
                                <div class="text-gray-700 mb-2">Waktu Pengerjaan</div>
                                <div class="text-xl font-semibold text-gray-900">
                                    <i class="far fa-clock text-primary-500 mr-2"></i>
                                    {{ $service->delivery_time }} hari
                                </div>
                            </div>
                            
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                
                                <div class="mb-6">
                                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                                    <input type="number" name="quantity" id="quantity" min="1" value="1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                
                                <div class="mb-6">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan Khusus</label>
                                    <textarea name="notes" id="notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Tuliskan kebutuhan atau pertanyaan Anda..."></textarea>
                                </div>
                                
                                <button type="submit" class="w-full flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Tambahkan Ke Keranjang
                                </button>
                            </form>
                        </div>
                        
                        <!-- Seller Info -->
                        <div class="bg-gray-50 p-6 border-t border-gray-200">
                            <h4 class="font-semibold text-gray-900 mb-2">CodeCraft</h4>
                            <p class="text-gray-600 text-sm mb-4">
                                Penyedia jasa digital profesional dengan lebih dari 5 tahun pengalaman.
                            </p>
                            <a href="{{ route('contact') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                                <i class="fas fa-comment-alt mr-1"></i>
                                Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Services -->
            @if($relatedServices->count() > 0)
                <div class="mt-12">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Layanan Terkait</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedServices as $relatedService)
                            <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                                <a href="{{ route('services.show', $relatedService->slug) }}">
                                    @if($relatedService->getFirstMediaUrl('thumbnail'))
                                        <img src="{{ $relatedService->getFirstMediaUrl('thumbnail') }}" alt="{{ $relatedService->name }}" class="w-full h-40 object-cover">
                                    @else
                                        <div class="w-full h-40 bg-gray-300 flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400 text-3xl"></i>
                                        </div>
                                    @endif
                                </a>
                                <div class="p-4">
                                    <a href="{{ route('services.show', $relatedService->slug) }}" class="block">
                                        <h3 class="text-lg font-semibold text-gray-900 hover:text-primary-600 transition-colors duration-300">{{ $relatedService->name }}</h3>
                                    </a>
                                    <div class="mt-2 flex justify-between items-center">
                                        <div class="text-gray-700">
                                            @if($relatedService->discounted_price)
                                                <span class="line-through text-gray-400 text-xs">Rp {{ number_format($relatedService->price, 0, ',', '.') }}</span>
                                                <span class="text-primary-600 font-semibold">Rp {{ number_format($relatedService->discounted_price, 0, ',', '.') }}</span>
                                            @else
                                                <span class="text-primary-600 font-semibold">Rp {{ number_format($relatedService->price, 0, ',', '.') }}</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-yellow-400 mr-1"><i class="fas fa-star"></i></span>
                                            <span class="text-sm text-gray-600">{{ number_format($relatedService->average_rating, 1) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>