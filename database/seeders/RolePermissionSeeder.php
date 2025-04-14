<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $superAdmin = Role::create(['name' => 'super-admin']);
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        // Create permissions
        // Users permissions
        $userPermissions = [
            'view users',
            'create users',
            'edit users', 
            'delete users',
        ];
        
        // Service permissions
        $servicePermissions = [
            'view services',
            'create services',
            'edit services',
            'delete services',
        ];
        
        // Category permissions
        $categoryPermissions = [
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
        ];
        
        // Order permissions
        $orderPermissions = [
            'view orders',
            'edit orders',
            'delete orders',
            'process orders',
            'complete orders',
            'cancel orders',
        ];
        
        // Transaction permissions
        $transactionPermissions = [
            'view transactions',
            'edit transactions',
            'refund transactions',
        ];
        
        // Review permissions
        $reviewPermissions = [
            'view reviews',
            'edit reviews',
            'delete reviews',
            'approve reviews',
        ];
        
        // Create all permissions
        $allPermissions = array_merge(
            $userPermissions,
            $servicePermissions,
            $categoryPermissions,
            $orderPermissions,
            $transactionPermissions,
            $reviewPermissions
        );
        
        foreach ($allPermissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

        // Super Admin has all permissions
        $superAdmin->givePermissionTo(Permission::all());
        
        // Admin has limited permissions
        $admin->givePermissionTo([
            'view users',
            'view services',
            'create services',
            'edit services',
            'view categories',
            'create categories', 
            'edit categories',
            'view orders',
            'edit orders',
            'process orders',
            'complete orders',
            'cancel orders',
            'view transactions',
            'view reviews',
            'edit reviews',
            'approve reviews',
        ]);
        
        // Regular user has no additional permissions
        // They will have permissions based on their ownership of resources
    }
}