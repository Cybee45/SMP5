<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class CleanupRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus role 'superadmin' (tanpa underscore) yang tidak digunakan
        $oldSuperadmin = Role::where('name', 'superadmin')->first();
        if ($oldSuperadmin) {
            // Pindahkan user dari 'superadmin' ke 'super_admin'
            $users = User::role('superadmin')->get();
            foreach ($users as $user) {
                $user->removeRole('superadmin');
                $user->assignRole('super_admin');
                echo "Moved user {$user->email} from 'superadmin' to 'super_admin'\n";
            }
            
            // Hapus role lama
            $oldSuperadmin->delete();
            echo "Deleted old 'superadmin' role\n";
        }

        // Pastikan semua user memiliki role yang benar
        $users = User::all();
        foreach ($users as $user) {
            if (!$user->hasAnyRole(['admin', 'super_admin'])) {
                // Jika user tidak memiliki role, berikan role admin
                $user->assignRole('admin');
                echo "Assigned 'admin' role to user {$user->email}\n";
            }
        }

        echo "Role cleanup completed!\n";
    }
}
