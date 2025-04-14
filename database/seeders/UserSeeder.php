<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah role admin ada
        $adminRole = Role::where('name', 'admin')->first();
        $superAdminRole = Role::where('name', 'super-admin')->first();
        $userRole = Role::where('name', 'user')->first();
        
        // Buat super admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@codecraft.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        
        if ($superAdminRole) {
            $superAdmin->assignRole($superAdminRole);
        } else {
            $this->command->warn('Role super-admin not found');
        }
        
        // Buat admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@codecraft.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        
        if ($adminRole) {
            $admin->assignRole($adminRole);
        } else {
            $this->command->warn('Role admin not found');
        }
        
        // Buat user biasa
        $user = User::create([
            'name' => 'User',
            'email' => 'user@codecraft.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        
        if ($userRole) {
            $user->assignRole($userRole);
        } else {
            $this->command->warn('Role user not found');
        }
    }
}