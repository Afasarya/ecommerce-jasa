<x-app-layout>
    <x-slot name="title">Tentang Kami</x-slot>
    
    <!-- Hero Section -->
    <section class="bg-primary-600 text-white py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Tentang CodeCraft</h1>
            <p class="text-xl text-primary-100 max-w-3xl mx-auto">
                Kami adalah penyedia jasa digital profesional yang berkomitmen untuk membantu bisnis Anda tumbuh dan berkembang di era digital.
            </p>
        </div>
    </section>
    
    <!-- Our Story -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Cerita Kami</h2>
                    <p class="text-gray-600 mb-4">
                        CodeCraft didirikan pada tahun 2020 oleh sekelompok profesional teknologi yang memiliki visi untuk menyediakan solusi digital terbaik bagi bisnis dari berbagai skala.
                    </p>
                    <p class="text-gray-600 mb-4">
                        Bermula dari studio kecil dengan tim yang terdiri dari 5 orang, kini kami telah berkembang menjadi salah satu penyedia jasa digital terkemuka dengan lebih dari 50 profesional berbakat.
                    </p>
                    <p class="text-gray-600">
                        Kami percaya bahwa setiap bisnis memiliki kebutuhan unik, dan itulah mengapa kami selalu mengutamakan pendekatan yang personal dan customized untuk setiap klien kami.
                    </p>
                </div>
                <div class="flex justify-center">
                    <img src="https://placehold.co/600x400" alt="Our Story" class="rounded-lg shadow-lg max-w-full h-auto">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Our Mission & Vision -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Misi & Visi</h2>
                <p class="mt-4 text-xl text-gray-600">Apa yang kami perjuangkan dan tujuan kami</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 text-primary-600 mb-6">
                        <i class="fas fa-bullseye text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Misi Kami</h3>
                    <p class="text-gray-600 mb-4">
                        Menyediakan solusi digital yang inovatif, berkualitas tinggi, dan terjangkau untuk membantu bisnis dari segala ukuran bertransformasi dan tumbuh di dunia digital.
                    </p>
                    <p class="text-gray-600">
                        Kami berkomitmen untuk selalu memberikan layanan terbaik dengan mengutamakan kepuasan klien, transparansi, dan hasil yang terukur.
                    </p>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-primary-100 text-primary-600 mb-6">
                        <i class="fas fa-eye text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Visi Kami</h3>
                    <p class="text-gray-600 mb-4">
                        Menjadi partner digital terpercaya yang membantu bisnis mencapai potensi maksimalnya melalui solusi teknologi yang tepat.
                    </p>
                    <p class="text-gray-600">
                        Kami bercita-cita untuk membentuk ekosistem digital yang inklusif, di mana setiap bisnis memiliki akses ke alat dan layanan digital berkualitas tinggi untuk berkembang.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Our Team -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Tim Kami</h2>
                <p class="mt-4 text-xl text-gray-600">Digerakkan oleh profesional berbakat dan berpengalaman</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="mb-4 relative mx-auto w-40 h-40 rounded-full overflow-hidden">
                        <img src="https://placehold.co/200x200" alt="CEO" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Rizki Pratama</h3>
                    <p class="text-primary-600 font-medium">CEO & Founder</p>
                    <div class="mt-2 flex justify-center space-x-3">
                        <a href="#" class="text-gray-500 hover:text-primary-600">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-primary-600">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="mb-4 relative mx-auto w-40 h-40 rounded-full overflow-hidden">
                        <img src="https://placehold.co/200x200" alt="CTO" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Dewi Anggraini</h3>
                    <p class="text-primary-600 font-medium">CTO</p>
                    <div class="mt-2 flex justify-center space-x-3">
                        <a href="#" class="text-gray-500 hover:text-primary-600">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-primary-600">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="mb-4 relative mx-auto w-40 h-40 rounded-full overflow-hidden">
                        <img src="https://placehold.co/200x200" alt="Creative Director" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Arya Kusuma</h3>
                    <p class="text-primary-600 font-medium">Creative Director</p>
                    <div class="mt-2 flex justify-center space-x-3">
                        <a href="#" class="text-gray-500 hover:text-primary-600">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-primary-600">
                            <i class="fab fa-behance"></i>
                        </a>
                    </div>
                </div>
                
                <div class="text-center">
                    <div class="mb-4 relative mx-auto w-40 h-40 rounded-full overflow-hidden">
                        <img src="https://placehold.co/200x200" alt="Marketing Manager" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Maya Putri</h3>
                    <p class="text-primary-600 font-medium">Marketing Manager</p>
                    <div class="mt-2 flex justify-center space-x-3">
                        <a href="#" class="text-gray-500 hover:text-primary-600">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-primary-600">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Our Values -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Nilai-Nilai Kami</h2>
                <p class="mt-4 text-xl text-gray-600">Prinsip yang menjadi dasar setiap langkah kami</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 text-primary-600 mb-4">
                        <i class="fas fa-star text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Keunggulan</h3>
                    <p class="text-gray-600">Kami selalu berusaha memberikan hasil terbaik dalam setiap proyek yang kami kerjakan.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 text-primary-600 mb-4">
                        <i class="fas fa-lightbulb text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Inovasi</h3>
                    <p class="text-gray-600">Kami terus berinovasi untuk menghadirkan solusi digital yang relevan dan efektif.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 text-primary-600 mb-4">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Kolaborasi</h3>
                    <p class="text-gray-600">Kami percaya bahwa kolaborasi yang baik dengan klien adalah kunci keberhasilan proyek.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 text-primary-600 mb-4">
                        <i class="fas fa-handshake text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Integritas</h3>
                    <p class="text-gray-600">Kami menjunjung tinggi kejujuran dan transparansi dalam setiap hubungan bisnis.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 text-primary-600 mb-4">
                        <i class="fas fa-heart text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Passion</h3>
                    <p class="text-gray-600">Kami mencintai apa yang kami lakukan dan selalu bersemangat dalam mengerjakan setiap proyek.</p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="inline-flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 text-primary-600 mb-4">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Pertumbuhan</h3>
                    <p class="text-gray-600">Kami berkomitmen untuk terus belajar dan berkembang, baik sebagai individu maupun sebagai perusahaan.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-12 bg-primary-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Bergabunglah dengan Klien Puas Kami</h2>
            <p class="text-xl text-primary-100 mb-8 max-w-3xl mx-auto">
                Biarkan kami membantu Anda mewujudkan visi digital Anda. Hubungi kami sekarang untuk konsultasi gratis.
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