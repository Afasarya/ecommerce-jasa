<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Jalankan RoleSeeder terlebih dahulu
        $this->call(RoleSeeder::class);
        
        // Baru jalankan UserSeeder
        $this->call(UserSeeder::class);
        
        // Kemudian seeder lainnya
      
    }
}