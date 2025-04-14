<x-app-layout>
    <x-slot name="title">Jasa Digital Profesional</x-slot>
    
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-primary-600 to-primary-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="order-2 md:order-1">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Solusi Digital Terbaik untuk Bisnis Anda</h1>
                    <p class="text-lg mb-8 text-primary-100">
                        CodeCraft menyediakan berbagai jasa digital profesional untuk membantu bisnis Anda tumbuh dan berkembang.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('services.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-primary-700 bg-white hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 shadow-lg">
                            Lihat Layanan
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-400">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
                <div class="order-1 md:order-2 flex justify-center">
                    <img src="https://placehold.co/600x400" alt="CodeCraft Hero" class="rounded-lg shadow-xl max-w-full h-auto">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Featured Categories -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Kategori Layanan</h2>
                <p class="mt-4 text-xl text-gray-600">Pilih kategori layanan yang sesuai dengan kebutuhan Anda</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($categories as $category)
                    <a href="{{ route('services.category', $category->slug) }}" class="block group">
                        <div class="bg-gray-50 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 p-6 text-center">
                            @if($category->getFirstMediaUrl('icon'))
                                <img src="{{ $category->getFirstMediaUrl('icon') }}" alt="{{ $category->name }}" class="mx-auto h-16 w-16 mb-4">
                            @else
                                <i class="{{ $category->icon ?? 'fas fa-cogs' }} text-primary-500 text-4xl mb-4"></i>
                            @endif
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors duration-300">{{ $category->name }}</h3>
                            <p class="mt-2 text-gray-600">{{ Str::limit($category->description, 100) }}</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">Tidak ada kategori yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="text-center mt-10">
                <a href="{{ route('services.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Lihat Semua Kategori
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Featured Services -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Layanan Unggulan</h2>
                <p class="mt-4 text-xl text-gray-600">Jasa digital berkualitas tinggi yang paling banyak dicari</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($featuredServices as $service)
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
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">Tidak ada layanan unggulan yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="text-center mt-10">
                <a href="{{ route('services.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-primary-600 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 shadow">
                    Lihat Semua Layanan
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>
    
    <!-- Why Choose Us -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Mengapa Memilih CodeCraft?</h2>
                <p class="mt-4 text-xl text-gray-600">Keunggulan kami dalam menyediakan jasa digital</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 text-primary-600 mb-4">
                        <i class="fas fa-award text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Kualitas Terbaik</h3>
                    <p class="text-gray-600">Kami berkomitmen untuk memberikan hasil terbaik dan memuaskan bagi setiap klien.</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 text-primary-600 mb-4">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Tepat Waktu</h3>
                    <p class="text-gray-600">Kami selalu menyelesaikan pekerjaan sesuai dengan timeline yang telah disepakati.</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 text-primary-600 mb-4">
                        <i class="fas fa-headset text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Layanan Pelanggan</h3>
                    <p class="text-gray-600">Tim kami siap membantu Anda dengan responsif dan profesional selama 24/7.</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 text-primary-600 mb-4">
                        <i class="fas fa-code text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Tim Ahli</h3>
                    <p class="text-gray-600">Diperkuat oleh tim profesional yang berpengalaman di bidangnya masing-masing.</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 text-primary-600 mb-4">
                        <i class="fas fa-sync-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Revisi Gratis</h3>
                    <p class="text-gray-600">Kami menyediakan revisi gratis untuk memastikan kepuasan Anda atas hasil pekerjaan.</p>
                </div>
                
                <div class="text-center p-6">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 text-primary-600 mb-4">
                        <i class="fas fa-shield-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Jaminan Kepuasan</h3>
                    <p class="text-gray-600">Kami memberikan garansi untuk setiap layanan yang kami berikan.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Apa Kata Mereka?</h2>
                <p class="mt-4 text-xl text-gray-600">Testimoni dari klien yang telah menggunakan jasa kami</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900">Ahmad Raditya</h4>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Saya sangat puas dengan hasil pekerjaan dari CodeCraft. Mereka sangat profesional dan komunikatif selama proses pengerjaan. Hasilnya melebihi ekspektasi saya!"</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900">Siti Nur</h4>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Tim CodeCraft sangat membantu dalam pengembangan website bisnis saya. Mereka memberikan solusi yang sesuai dengan kebutuhan dan anggaran saya. Sangat direkomendasikan!"</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-900">Budi Santoso</h4>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600 italic">"Layanan desain grafis dari CodeCraft sangat mengesankan. Mereka mampu menerjemahkan ide saya menjadi desain yang menarik dan profesional. Pasti akan menggunakan jasa mereka lagi!"</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-12 bg-primary-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Siap Untuk Memulai Proyek Bersama?</h2>
            <p class="text-xl text-primary-100 mb-8 max-w-3xl mx-auto">
                Hubungi kami sekarang dan diskusikan kebutuhan digital Anda bersama tim profesional kami.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('services.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-primary-700 bg-white hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 shadow-lg">
                    Lihat Layanan
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-400">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>
</x-app-layout>