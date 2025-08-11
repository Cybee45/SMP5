<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat atau cari user superadmin
        $user = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'), // Ganti password sebelum production
            ]
        );

        // 2. Buat role superadmin
        $role = Role::firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'web', // Sesuaikan dengan guard Filament kamu (web/admin)
        ]);

        // 3. Beri semua permission ke role superadmin
        $allPermissions = Permission::pluck('name')->toArray();
        $role->syncPermissions($allPermissions);

        // 4. Assign role ke user
        $user->assignRole($role);

        $this->command->info("✅ Superadmin berhasil disiapkan dengan email admin@example.com dan password 'password'");
    }
}
