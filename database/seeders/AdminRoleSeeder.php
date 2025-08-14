<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Get all permissions except super admin specific ones
        $permissions = Permission::whereNotIn('name', [
            'create_user',
            'update_user', 
            'delete_user',
            'view_any_user',
            'create_role',
            'update_role',
            'delete_role',
            'view_any_role',
            'create_permission',
            'update_permission', 
            'delete_permission',
            'view_any_permission'
        ])->get();
        
        // Assign permissions to admin role
        $adminRole->syncPermissions($permissions);
        
        $this->command->info('Admin role created/updated with appropriate permissions.');
    }
}
