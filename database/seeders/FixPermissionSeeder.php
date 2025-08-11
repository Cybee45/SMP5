<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class FixPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil role yang ada
        $superRole = Role::where('name', 'super_admin')->first();
        $adminRole = Role::where('name', 'admin')->first();

        if ($superRole) {
            // Superadmin dapat semua permission
            $superRole->syncPermissions(['cms_manage', 'system_manage', 'dashboard_access']);
            $this->command->info('✅ Superadmin permissions updated');
        }

        if ($adminRole) {
            // Admin hanya CMS dan dashboard
            $adminRole->syncPermissions(['cms_manage', 'dashboard_access']);
            $this->command->info('✅ Admin permissions updated');
        }

        $this->command->info('🎯 Permission assignment completed!');
    }
}
