<footer class="bg-gray-800 text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-1 lg:col-span-1">
                <h3 class="text-lg font-bold mb-4">CodeCraft</h3>
                <p class="text-gray-300 text-sm">
                    Kami menyediakan jasa digital berkualitas tinggi untuk membantu bisnis Anda tumbuh dan berkembang.
                </p>
                <div class="mt-4 flex space-x-4">
                    <a href="#" class="text-gray-300 hover:text-white">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-white">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-span-1">
                <h3 class="text-lg font-bold mb-4">Navigasi</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white">Beranda</a></li>
                    <li><a href="{{ route('services.index') }}" class="text-gray-300 hover:text-white">Layanan</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-white">Tentang Kami</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white">Kontak</a></li>
                </ul>
            </div>
            
            <div class="col-span-1">
                <h3 class="text-lg font-bold mb-4">Layanan</h3>
                <ul class="space-y-2 text-sm">
                    @foreach(\App\Models\ServiceCategory::active()->orderBy('sort_order')->limit(5)->get() as $category)
                        <li><a href="{{ route('services.category', $category->slug) }}" class="text-gray-300 hover:text-white">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            
            <div class="col-span-1">
                <h3 class="text-lg font-bold mb-4">Kontak</h3>
                <ul class="space-y-2 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-2 text-primary-400"></i>
                        <span class="text-gray-300">Jl. Contoh No. 123, Jakarta, Indonesia</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-phone-alt mt-1 mr-2 text-primary-400"></i>
                        <span class="text-gray-300">+62 123 4567 890</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-envelope mt-1 mr-2 text-primary-400"></i>
                        <span class="text-gray-300">info@codecraft.com</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-700 mt-8 pt-6 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} CodeCraft. All rights reserved.
            </p>
            <div class="mt-4 md:mt-0 flex space-x-4 text-sm">
                <a href="{{ route('terms') }}" class="text-gray-400 hover:text-white">Syarat & Ketentuan</a>
                <a href="{{ route('privacy') }}" class="text-gray-400 hover:text-white">Kebijakan Privasi</a>
            </div>
        </div>
    </div>
</footer>