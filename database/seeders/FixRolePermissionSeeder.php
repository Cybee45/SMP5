<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class FixRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan permission ada
        $permissions = ['cms_manage', 'system_manage', 'dashboard_access'];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Update role permissions
        $superRole = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'web']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Assign permissions
        $superRole->givePermissionTo(['cms_manage', 'system_manage', 'dashboard_access']);
        $adminRole->givePermissionTo(['cms_manage', 'dashboard_access']);

        $this->command->info('✅ Role permissions fixed!');
        $this->command->info('Superadmin: cms_manage, system_manage, dashboard_access');
        $this->command->info('Admin: cms_manage, dashboard_access');
    }
}
