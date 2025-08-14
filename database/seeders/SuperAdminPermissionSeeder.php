<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create basic roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Create essential permissions only
        $essentialPermissions = [
            'view_any_user',
            'create_user', 
            'update_user',
            'delete_user',
            'view_any_role',
            'create_role',
            'update_role', 
            'delete_role',
            'view_any_permission',
            'create_permission',
            'update_permission',
            'delete_permission',
            'view_any_hero',
            'create_hero',
            'update_hero',
            'delete_hero',
            'view_any_keunggulan',
            'create_keunggulan', 
            'update_keunggulan',
            'delete_keunggulan',
            'view_any_statistik',
            'create_statistik',
            'update_statistik', 
            'delete_statistik',
            'view_any_section::keunggulan',
            'create_section::keunggulan',
            'update_section::keunggulan',
            'delete_section::keunggulan',
            'view_any_profil',
            'create_profil',
            'update_profil',
            'delete_profil',
            'view_any_about::hero',
            'create_about::hero',
            'update_about::hero',
            'delete_about::hero',
            'view_any_prestasi::about',
            'create_prestasi::about',
            'update_prestasi::about',
            'delete_prestasi::about',
            'view_any_tim::birokrasi',
            'create_tim::birokrasi',
            'update_tim::birokrasi',
            'delete_tim::birokrasi',
            'view_any_visi::misi',
            'create_visi::misi',
            'update_visi::misi',
            'delete_visi::misi',
        ];

        // Create permissions if they don't exist
        foreach ($essentialPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Give super_admin all essential permissions
        $superAdminRole->syncPermissions($essentialPermissions);
        
        // Give admin basic CMS permissions
        $adminPermissions = array_filter($essentialPermissions, function($perm) {
            return !str_contains($perm, 'user') && !str_contains($perm, 'role') && !str_contains($perm, 'permission');
        });
        $adminRole->syncPermissions($adminPermissions);
        
        echo "✅ Essential permissions created and assigned!" . PHP_EOL;
        echo "Super Admin permissions: " . count($essentialPermissions) . PHP_EOL;
        echo "Admin permissions: " . count($adminPermissions) . PHP_EOL;
    }
}
