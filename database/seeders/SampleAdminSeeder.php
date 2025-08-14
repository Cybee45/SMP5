<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class SampleAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin role if not exists
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        
        // Find existing admin user or create new one with different username
        $existingAdmin = User::where('username', 'admin')->first();
        
        if ($existingAdmin) {
            // If admin user exists, just assign admin role
            if (!$existingAdmin->hasRole('admin')) {
                $existingAdmin->assignRole('admin');
            }
            $this->command->info('Existing admin user updated with admin role: ' . $existingAdmin->email);
        } else {
            // Create new admin user
            $adminUser = User::create([
                'name' => 'Admin SMP 5',
                'username' => 'admin_smp5',
                'email' => 'admin@smp5.sch.id', 
                'password' => Hash::make('admin123'),
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            // Assign admin role
            $adminUser->assignRole('admin');
            $this->command->info('Sample admin user created: admin@smp5.sch.id / admin123');
        }
    }
}
