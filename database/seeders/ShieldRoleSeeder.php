<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ShieldRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if they don't exist
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Reset role permissions
        $superadminRole->permissions()->sync([]);
        $adminRole->permissions()->sync([]);

        // Get all permissions
        $allPermissions = Permission::all();

        // Assign ALL permissions to superadmin
        $superadminRole->givePermissionTo($allPermissions);

        // Define CMS permissions for admin (exclude user management, role management, and permission management)
        $adminPermissions = $allPermissions->filter(function ($permission) {
            return !str_contains($permission->name, 'user') && 
                   !str_contains($permission->name, 'role') && 
                   !str_contains($permission->name, 'permission');
        });

        // Assign CMS permissions to admin
        $adminRole->givePermissionTo($adminPermissions);

        // Create or update superadmin user
        $superadmin = User::updateOrCreate(
            ['email' => 'superadmin@smp5sangatta.sch.id'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('superadmin123'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        
        // Remove all roles first, then assign superadmin role
        $superadmin->syncRoles([]);
        $superadmin->assignRole($superadminRole);

        // Create or update admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@smp5sangatta.sch.id'],
            [
                'name' => 'Administrator CMS',
                'password' => Hash::make('admin123'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        
        // Remove all roles first, then assign admin role
        $admin->syncRoles([]);
        $admin->assignRole($adminRole);

        // Display information
        $this->command->info('Shield Role Seeder completed successfully!');
        $this->command->info('');
        $this->command->info('=== ACCOUNT INFORMATION ===');
        $this->command->info('Superadmin: superadmin@smp5sangatta.sch.id / superadmin123');
        $this->command->info('Admin CMS: admin@smp5sangatta.sch.id / admin123');
        $this->command->info('');
        
        $this->command->info('=== PERMISSION SUMMARY ===');
        $this->command->info('Superadmin permissions: ' . $superadminRole->permissions->count());
        $this->command->info('Admin permissions: ' . $adminRole->permissions->count());
        
        $this->command->info('');
        $this->command->info('=== ADMIN EXCLUDED PERMISSIONS ===');
        $excludedPermissions = $allPermissions->diff($adminPermissions);
        foreach ($excludedPermissions as $perm) {
            $this->command->info('- ' . $perm->name);
        }
    }
}
