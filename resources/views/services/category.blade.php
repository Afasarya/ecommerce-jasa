<x-app-layout>
    <x-slot name="title">{{ $category->name }}</x-slot>
    
    <!-- Hero Section -->
    <section class="bg-primary-600 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">{{ $category->name }}</h1>
                <p class="text-xl text-primary-100 max-w-3xl mx-auto">
                    {{ $category->description }}
                </p>
            </div>
        </div>
    </section>
    
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
                        <span class="text-gray-700" aria-current="page">{{ $category->name }}</span>
                    </li>
                </ol>
            </nav>
        </div>
    </section>
    
    <!-- Services Grid -->
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">
                    Layanan dalam kategori "{{ $category->name }}"
                </h2>
            </div>
            
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
                            <i class="fas fa-box-open text-4xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada layanan ditemukan</h3>
                        <p class="text-gray-500 mb-6">Belum ada layanan dalam kategori ini</p>
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