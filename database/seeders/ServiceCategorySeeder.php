<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceCategory;
use Illuminate\Support\Str;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'description' => 'Jasa pembuatan website profesional untuk berbagai kebutuhan bisnis, mulai dari website company profile hingga e-commerce',
                'icon' => 'fas fa-globe',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'Jasa pengembangan aplikasi mobile untuk platform Android dan iOS yang responsif dan user-friendly',
                'icon' => 'fas fa-mobile-alt',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Graphic Design',
                'description' => 'Jasa desain grafis profesional untuk kebutuhan branding, marketing material, dan media sosial',
                'icon' => 'fas fa-paint-brush',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Digital Marketing',
                'description' => 'Jasa digital marketing untuk meningkatkan awareness dan penjualan produk atau jasa Anda secara online',
                'icon' => 'fas fa-chart-line',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Content Writing',
                'description' => 'Jasa penulisan konten profesional untuk website, blog, artikel, dan media sosial',
                'icon' => 'fas fa-pen',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Jasa desain user interface dan user experience untuk meningkatkan kualitas interaksi pengguna dengan produk digital Anda',
                'icon' => 'fas fa-desktop',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Video Editing',
                'description' => 'Jasa editing video profesional untuk konten Youtube, iklan, presentasi, dan kebutuhan lainnya',
                'icon' => 'fas fa-video',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Data Analysis',
                'description' => 'Jasa analisis data untuk membantu pengambilan keputusan bisnis berdasarkan data dan insights yang akurat',
                'icon' => 'fas fa-chart-pie',
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'icon' => $category['icon'],
                'is_active' => $category['is_active'],
                'sort_order' => $category['sort_order'],
            ]);
        }
    }
}
