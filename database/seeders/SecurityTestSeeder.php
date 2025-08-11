<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class SecurityTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== SECURITY TESTING ===');
        
        $user = User::first();
        
        $this->command->info('Testing User Security Fields:');
        $this->command->info('User: ' . $user->email);
        $this->command->info('Login attempts: ' . $user->login_attempts);
        $this->command->info('Last login: ' . ($user->last_login_at ?? 'Never'));
        $this->command->info('Last IP: ' . ($user->last_login_ip ?? 'None'));
        $this->command->info('Locked until: ' . ($user->locked_until ?? 'Not locked'));
        
        $this->command->info('');
        $this->command->info('Testing User Methods:');
        $this->command->info('Is locked: ' . ($user->isLocked() ? 'Yes' : 'No'));
        $this->command->info('Can access panel: ' . ($user->canAccessPanel() ? 'Yes' : 'No'));
        $this->command->info('Is superadmin: ' . ($user->isSuperAdmin() ? 'Yes' : 'No'));
        $this->command->info('Is admin: ' . ($user->isAdmin() ? 'Yes' : 'No'));
        
        $this->command->info('');
        $this->command->info('Testing Password Strength:');
        $weakPassword = 'password123';
        $strongPassword = 'MySecure@Pass123!';
        $this->command->info('Weak password valid: ' . (User::isStrongPassword($weakPassword) ? 'Yes' : 'No'));
        $this->command->info('Strong password valid: ' . (User::isStrongPassword($strongPassword) ? 'Yes' : 'No'));
        
        $this->command->info('');
        $this->command->info('Security fields test completed!');
    }
}
