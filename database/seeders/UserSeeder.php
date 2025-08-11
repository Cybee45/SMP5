<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role jika belum ada
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $superadminRole = Role::firstOrCreate(['name' => 'super_admin']);

        // Buat user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => bcrypt('password')]
        );

        // Assign role
        $admin->assignRole($superadminRole);
    }
}
