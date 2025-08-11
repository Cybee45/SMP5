<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SimplePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache permission
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Hapus semua permission yang ada
        Permission::query()->delete();

        // Permission yang disederhanakan - hanya 3 level
        $permissions = [
            // CMS Management - untuk content
            'cms_manage' => 'Kelola Konten CMS',
            
            // System Management - untuk user & role (superadmin only)
            'system_manage' => 'Kelola Sistem & User',
            
            // Dashboard access
            'dashboard_access' => 'Akses Dashboard',
        ];

        // Buat permission
        foreach ($permissions as $name => $display_name) {
            Permission::create([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }

        // Update role permissions
        $superadmin = Role::where('name', 'super_admin')->first();
        $admin = Role::where('name', 'admin')->first();

        if ($superadmin) {
            // Superadmin dapat semua permission
            $superadmin->syncPermissions(['cms_manage', 'system_manage', 'dashboard_access']);
        }

        if ($admin) {
            // Admin hanya CMS dan dashboard
            $admin->syncPermissions(['cms_manage', 'dashboard_access']);
        }

        $this->command->info('✅ Permission berhasil disederhanakan menjadi 3 level:');
        $this->command->info('   - cms_manage (Admin & Superadmin)');
        $this->command->info('   - system_manage (Superadmin only)');
        $this->command->info('   - dashboard_access (Admin & Superadmin)');
    }
}
