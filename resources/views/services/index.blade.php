<x-app-layout>
    <x-slot name="title">Layanan</x-slot>
    
    <!-- Hero Section -->
    <section class="bg-primary-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Layanan Kami</h1>
                <p class="text-xl text-primary-100 max-w-3xl mx-auto">
                    Jelajahi berbagai jasa digital profesional untuk membantu bisnis Anda tumbuh di era digital
                </p>
            </div>
        </div>
    </section>
    
    <!-- Filter & Search -->
    <section class="bg-white shadow-md py-4 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('services.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 justify-between">
                <div class="flex flex-col sm:flex-row gap-4 flex-grow">
                    <div class="w-full sm:w-auto">
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="category" id="category" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="w-full sm:w-auto">
                        <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                        <select name="sort" id="sort" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex-grow md:flex-grow-0">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                    <div class="relative rounded-md shadow-sm">
                        <input type="text" name="search" id="search" value="{{ request('search') }}" class="block w-full rounded-md border-gray-300 pl-4 pr-10 focus:border-primary-500 focus:ring-primary-500" placeholder="Cari layanan...">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <button type="submit" class="text-gray-400 hover:text-gray-500">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    
    <!-- Services Grid -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(request('search') || request('category'))
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">
                        Hasil pencarian untuk 
                        @if(request('search'))
                            "{{ request('search') }}" 
                        @endif
                        @if(request('category'))
                            dalam kategori "{{ $categories->where('slug', request('category'))->first()->name ?? '' }}"
                        @endif
                    </h2>
                </div>
            @endif
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($services as $service)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300">
                        <a href="{{ route('services.show', $service->slug) }}">
                            @if($service->getFirstMediaUrl('thumbnail'))
                                <img src="{{ $service->getFirstMediaUrl('thumbnail') }}" alt="{{ $service->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                        </a>
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <a href="{{ route('services.category', $service->category->slug) }}" class="text-xs text-primary-600 font-semibold uppercase tracking-wide">
                                        {{ $service->category->name }}
                                    </a>
                                    <a href="{{ route('services.show', $service->slug) }}" class="block mt-2">
                                        <h3 class="text-xl font-semibold text-gray-900 hover:text-primary-600 transition-colors duration-300">{{ $service->name }}</h3>
                                    </a>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-yellow-400">
                                        <i class="fas fa-star"></i>
                                    </span>
                                    <span class="ml-1 text-gray-700">{{ number_format($service->average_rating, 1) }}</span>
                                </div>
                            </div>
                            <p class="mt-3 text-gray-600">{{ Str::limit($service->short_description, 100) }}</p>
                            <div class="mt-4 flex justify-between items-center">
                                <div class="text-gray-700">
                                    <span class="text-xs text-gray-500">Mulai dari</span>
                                    <p class="font-bold text-lg">
                                        @if($service->discounted_price)
                                            <span class="line-through text-gray-400 text-sm">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                            <span class="text-primary-600">Rp {{ number_format($service->discounted_price, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-primary-600">Rp {{ number_format($service->price, 0, ',', '.') }}</span>
                                        @endif
                                    </p>
                                </div>
                                <a href="{{ route('services.show', $service->slug) }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center">
                        <div class="inline-flex items-center justify-center h-24 w-24 rounded-full bg-gray-100 text-gray-400 mb-6">
                            <i class="fas fa-search text-4xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada layanan ditemukan</h3>
                        <p class="text-gray-500 mb-6">Coba ubah filter atau kata kunci pencarian Anda</p>
                        <a href="{{ route('services.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            Lihat Semua Layanan
                        </a>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $services->links() }}
            </div>
        </div>
    </section>
</x-app-layout>