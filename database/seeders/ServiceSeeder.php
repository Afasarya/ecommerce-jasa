<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Layanan Web Development
        $webDevCategory = ServiceCategory::where('name', 'Web Development')->first();
        if ($webDevCategory) {
            $services = [
                [
                    'name' => 'Website Company Profile',
                    'short_description' => 'Pembuatan website company profile profesional untuk bisnis Anda',
                    'description' => '<p>Kami akan membuatkan website company profile profesional yang menampilkan identitas bisnis Anda secara online. Website yang kami buat responsif, modern, dan SEO-friendly.</p><p>Website company profile yang kami buat akan memiliki halaman utama, tentang kami, layanan, portfolio, blog, dan kontak. Anda dapat menyesuaikan halaman sesuai kebutuhan.</p>',
                    'price' => 3500000,
                    'discounted_price' => 2999000,
                    'delivery_time' => 7,
                    'what_you_get' => [
                        ['item' => 'Website responsif untuk semua perangkat'],
                        ['item' => 'Hingga 10 halaman website'],
                        ['item' => 'Form kontak & Google Maps'],
                        ['item' => 'Integrasi media sosial'],
                        ['item' => 'Optimasi SEO dasar'],
                    ],
                    'is_featured' => true,
                ],
                [
                    'name' => 'Website E-Commerce',
                    'short_description' => 'Pembuatan toko online dengan fitur lengkap dan sistem pembayaran terintegrasi',
                    'description' => '<p>Kami akan membuatkan website e-commerce profesional yang membantu Anda menjual produk atau jasa secara online. Website e-commerce yang kami buat dilengkapi dengan sistem manajemen produk, keranjang belanja, dan pembayaran.</p><p>Website e-commerce kami didukung oleh sistem pembayaran terintegrasi seperti Midtrans, sehingga memudahkan customer Anda dalam bertransaksi.</p>',
                    'price' => 8500000,
                    'discounted_price' => 7500000,
                    'delivery_time' => 21,
                    'what_you_get' => [
                        ['item' => 'Website responsif untuk semua perangkat'],
                        ['item' => 'Manajemen produk dan kategori'],
                        ['item' => 'Sistem keranjang dan checkout'],
                        ['item' => 'Integrasi payment gateway'],
                        ['item' => 'Panel admin untuk mengelola pesanan'],
                        ['item' => 'Sistem member dan wishlist'],
                    ],
                    'is_featured' => true,
                ],
                [
                    'name' => 'Single Page Application (SPA)',
                    'short_description' => 'Pembuatan aplikasi web modern dengan teknologi SPA',
                    'description' => '<p>Kami akan membuatkan single page application (SPA) yang modern dan cepat dengan menggunakan teknologi terkini seperti React, Vue, atau Angular. SPA memberikan pengalaman pengguna yang lebih baik dengan perpindahan halaman yang cepat dan responsif.</p>',
                    'price' => 6000000,
                    'discounted_price' => null,
                    'delivery_time' => 14,
                    'what_you_get' => [
                        ['item' => 'Aplikasi web modern dengan teknologi SPA'],
                        ['item' => 'Frontend dengan React, Vue, atau Angular'],
                        ['item' => 'RESTful API untuk backend'],
                        ['item' => 'Performa cepat dan responsif'],
                        ['item' => 'Dokumentasi code'],
                    ],
                    'is_featured' => false,
                ],
            ];

            foreach ($services as $service) {
                Service::create([
                    'category_id' => $webDevCategory->id,
                    'name' => $service['name'],
                    'slug' => Str::slug($service['name']),
                    'short_description' => $service['short_description'],
                    'description' => $service['description'],
                    'price' => $service['price'],
                    'discounted_price' => $service['discounted_price'],
                    'delivery_time' => $service['delivery_time'],
                    'what_you_get' => $service['what_you_get'],
                    'is_featured' => $service['is_featured'],
                    'is_active' => true,
                ]);
            }
        }

        // Layanan Mobile App Development
        $mobileDevCategory = ServiceCategory::where('name', 'Mobile App Development')->first();
        if ($mobileDevCategory) {
            $services = [
                [
                    'name' => 'Android App Development',
                    'short_description' => 'Pembuatan aplikasi Android untuk kebutuhan bisnis atau personal Anda',
                    'description' => '<p>Kami akan membuatkan aplikasi Android yang sesuai dengan kebutuhan bisnis atau personal Anda. Aplikasi yang kami buat memiliki user interface yang intuitif dan performa yang baik.</p><p>Aplikasi Android yang kami kembangkan dapat terintegrasi dengan sistem backend dan API yang Anda miliki, atau kami dapat membuatkan backend baru sesuai kebutuhan.</p>',
                    'price' => 10000000,
                    'discounted_price' => 8500000,
                    'delivery_time' => 30,
                    'what_you_get' => [
                        ['item' => 'Aplikasi Android native atau hybrid'],
                        ['item' => 'UI/UX design yang menarik'],
                        ['item' => 'Integrasi API dan backend'],
                        ['item' => 'Optimasi performa'],
                        ['item' => 'Publikasi ke Google Play Store'],
                    ],
                    'is_featured' => true,
                ],
                [
                    'name' => 'iOS App Development',
                    'short_description' => 'Pembuatan aplikasi iOS untuk iPhone dan iPad',
                    'description' => '<p>Kami akan membuatkan aplikasi iOS profesional untuk perangkat iPhone dan iPad. Aplikasi iOS yang kami buat mengikuti guideline Apple untuk memberikan pengalaman pengguna terbaik.</p><p>Aplikasi iOS kami kembangkan dengan Swift atau React Native, tergantung kebutuhan dan anggaran Anda.</p>',
                    'price' => 12000000,
                    'discounted_price' => 10500000,
                    'delivery_time' => 30,
                    'what_you_get' => [
                        ['item' => 'Aplikasi iOS native atau hybrid'],
                        ['item' => 'UI/UX design sesuai Apple guidelines'],
                        ['item' => 'Integrasi API dan backend'],
                        ['item' => 'Optimasi performa'],
                        ['item' => 'Publikasi ke App Store'],
                    ],
                    'is_featured' => false,
                ],
            ];

            foreach ($services as $service) {
                Service::create([
                    'category_id' => $mobileDevCategory->id,
                    'name' => $service['name'],
                    'slug' => Str::slug($service['name']),
                    'short_description' => $service['short_description'],
                    'description' => $service['description'],
                    'price' => $service['price'],
                    'discounted_price' => $service['discounted_price'],
                    'delivery_time' => $service['delivery_time'],
                    'what_you_get' => $service['what_you_get'],
                    'is_featured' => $service['is_featured'],
                    'is_active' => true,
                ]);
            }
        }

        // Layanan Graphic Design
        $graphicDesignCategory = ServiceCategory::where('name', 'Graphic Design')->first();
        if ($graphicDesignCategory) {
            $services = [
                [
                    'name' => 'Logo Design',
                    'short_description' => 'Desain logo profesional untuk brand Anda',
                    'description' => '<p>Kami akan membuatkan logo profesional yang mencerminkan identitas brand Anda. Logo yang kami desain unik, memorable, dan versatile untuk berbagai kebutuhan marketing.</p><p>Proses design logo kami melalui beberapa tahap, mulai dari konsep, sketsa, hingga finalisasi design. Anda akan mendapatkan beberapa konsep alternatif untuk dipilih.</p>',
                    'price' => 1500000,
                    'discounted_price' => 1200000,
                    'delivery_time' => 7,
                    'what_you_get' => [
                        ['item' => '3 konsep logo alternatif'],
                        ['item' => 'Revisi unlimited hingga puas'],
                        ['item' => 'File source format AI dan PSD'],
                        ['item' => 'File PNG dan JPG transparent'],
                        ['item' => 'Brand guidelines sederhana'],
                    ],
                    'is_featured' => true,
                ],
                [
                    'name' => 'Social Media Design',
                    'short_description' => 'Desain konten media sosial yang menarik untuk meningkatkan engagement',
                    'description' => '<p>Kami akan membuatkan desain konten media sosial yang menarik dan konsisten dengan brand Anda. Desain yang kami buat dapat digunakan untuk Instagram, Facebook, Twitter, dan platform lainnya.</p><p>Paket social media design kami mencakup design untuk feed, story, dan cover page yang dapat disesuaikan dengan kebutuhan marketing Anda.</p>',
                    'price' => 2500000,
                    'discounted_price' => null,
                    'delivery_time' => 7,
                    'what_you_get' => [
                        ['item' => '10 desain feed Instagram/Facebook'],
                        ['item' => '5 desain story Instagram/Facebook'],
                        ['item' => 'Cover page untuk Facebook dan Twitter'],
                        ['item' => 'File PSD/AI source'],
                        ['item' => '2x revisi per design'],
                    ],
                    'is_featured' => false,
                ],
            ];

            foreach ($services as $service) {
                Service::create([
                    'category_id' => $graphicDesignCategory->id,
                    'name' => $service['name'],
                    'slug' => Str::slug($service['name']),
                    'short_description' => $service['short_description'],
                    'description' => $service['description'],
                    'price' => $service['price'],
                    'discounted_price' => $service['discounted_price'],
                    'delivery_time' => $service['delivery_time'],
                    'what_you_get' => $service['what_you_get'],
                    'is_featured' => $service['is_featured'],
                    'is_active' => true,
                ]);
            }
        }

        // Dan seterusnya untuk kategori lainnya...
    }
}