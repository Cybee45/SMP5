<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create basic permissions for CMS
        $permissions = [
            // System Management (Superadmin only)
            'view_any_user',
            'view_user',
            'create_user',
            'update_user',
            'delete_user',
            'delete_any_user',

            'view_any_role',
            'view_role',
            'create_role',
            'update_role',
            'delete_role',
            'delete_any_role',

            // CMS Content Management
            'view_any_hero',
            'view_hero',
            'create_hero',
            'update_hero',
            'delete_hero',
            'delete_any_hero',

            'view_any_keunggulan',
            'view_keunggulan',
            'create_keunggulan',
            'update_keunggulan',
            'delete_keunggulan',
            'delete_any_keunggulan',

            'view_any_statistik',
            'view_statistik',
            'create_statistik',
            'update_statistik',
            'delete_statistik',
            'delete_any_statistik',

            // Additional CMS permissions
            'view_any_artikel',
            'view_artikel',
            'create_artikel',
            'update_artikel',
            'delete_artikel',

            'view_any_galeri',
            'view_galeri',
            'create_galeri',
            'update_galeri',
            'delete_galeri',

            'view_any_pengumuman',
            'view_pengumuman',
            'create_pengumuman',
            'update_pengumuman',
            'delete_pengumuman',

            'view_any_kontak',
            'view_kontak',
            'create_kontak',
            'update_kontak',
            'delete_kontak',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to superadmin
        $superadminRole->givePermissionTo(Permission::all());

        // Assign selected permissions to admin (CMS only, no system management)
        $adminPermissions = Permission::where(function($query) {
            $query->where('name', 'like', '%hero%')
                  ->orWhere('name', 'like', '%keunggulan%')
                  ->orWhere('name', 'like', '%statistik%')
                  ->orWhere('name', 'like', '%artikel%')
                  ->orWhere('name', 'like', '%galeri%')
                  ->orWhere('name', 'like', '%pengumuman%')
                  ->orWhere('name', 'like', '%kontak%');
        })->whereNotIn('name', [
            'delete_any_hero',
            'delete_any_keunggulan', 
            'delete_any_statistik',
            'delete_artikel',
            'delete_galeri',
            'delete_pengumuman',
            'delete_kontak'
        ])->get();
        
        $adminRole->givePermissionTo($adminPermissions);

        // Create superadmin user
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@smp5sangatta.sch.id'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('superadmin123'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $superadmin->assignRole($superadminRole);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@smp5sangatta.sch.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($adminRole);

        $this->command->info('Admin users created successfully!');
        $this->command->info('Superadmin: superadmin@smp5sangatta.sch.id / superadmin123');
        $this->command->info('Admin: admin@smp5sangatta.sch.id / admin123');
    }
}
