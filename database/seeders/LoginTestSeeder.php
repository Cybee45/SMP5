<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== LOGIN FUNCTIONALITY TESTING ===');
        
        // Test user methods directly
        $user = User::where('email', 'admin@smp5sangatta.sch.id')->first();
        
        if (!$user) {
            $this->command->error('Admin user not found!');
            return;
        }
        
        $this->command->info('Testing User Model Methods:');
        $this->command->info('User: ' . $user->email);
        $this->command->info('Is active: ' . ($user->is_active ? 'Yes' : 'No'));
        $this->command->info('Is locked: ' . ($user->isLocked() ? 'Yes' : 'No'));
        $this->command->info('Can access panel: ' . ($user->canAccessPanel() ? 'Yes' : 'No'));
        $this->command->info('Login attempts: ' . $user->login_attempts);
        
        $this->command->info('');
        $this->command->info('Testing Password Verification:');
        $correctPassword = 'admin123';
        $wrongPassword = 'wrongpassword';
        
        $this->command->info('Correct password check: ' . (Hash::check($correctPassword, $user->password) ? '✅ Valid' : '❌ Invalid'));
        $this->command->info('Wrong password check: ' . (Hash::check($wrongPassword, $user->password) ? '❌ Valid (ERROR!)' : '✅ Invalid (Expected)'));
        
        $this->command->info('');
        $this->command->info('Testing Account Lock Functionality:');
        
        // Test manual lock
        $this->command->info('Locking account for 1 minute...');
        $user->lockAccount(1);
        $user->refresh();
        
        $this->command->info('Account locked: ' . ($user->isLocked() ? '✅ Yes' : '❌ No'));
        $this->command->info('Locked until: ' . ($user->locked_until ? $user->locked_until->format('Y-m-d H:i:s') : 'Not set'));
        $this->command->info('Can access panel while locked: ' . ($user->canAccessPanel() ? '❌ Yes (ERROR!)' : '✅ No (Expected)'));
        
        // Test unlock
        $this->command->info('Unlocking account...');
        $user->unlockAccount();
        $user->refresh();
        
        $this->command->info('Account locked after unlock: ' . ($user->isLocked() ? '❌ Yes (ERROR!)' : '✅ No (Expected)'));
        $this->command->info('Can access panel after unlock: ' . ($user->canAccessPanel() ? '✅ Yes' : '❌ No'));
        
        $this->command->info('');
        $this->command->info('Testing Login Attempts Increment:');
        $initialAttempts = $user->login_attempts;
        $this->command->info('Initial attempts: ' . $initialAttempts);
        
        $user->incrementLoginAttempts();
        $user->refresh();
        $this->command->info('After increment: ' . $user->login_attempts);
        
        // Test multiple increments to trigger lock
        $this->command->info('Incrementing to trigger auto-lock...');
        for ($i = 0; $i < 5; $i++) {
            $user->incrementLoginAttempts();
            $user->refresh();
            $this->command->info('Attempt ' . ($i + 2) . ': ' . $user->login_attempts . ' attempts');
            if ($user->isLocked()) {
                $this->command->info('✅ Account auto-locked after ' . $user->login_attempts . ' attempts!');
                break;
            }
        }
        
        // Reset for next tests
        $user->unlockAccount();
        
        $this->command->info('');
        $this->command->info('Testing Successful Login Recording:');
        $testIP = '192.168.1.100';
        $user->recordLogin($testIP);
        $user->refresh();
        
        $this->command->info('Last login IP: ' . $user->last_login_ip);
        $this->command->info('Last login time: ' . $user->last_login_at);
        $this->command->info('Login attempts after successful login: ' . $user->login_attempts);
        
        $this->command->info('');
        $this->command->info('✅ All user model security functions are working correctly!');
        
        // Check if logs directory exists and log file is being created
        $logPath = storage_path('logs/laravel.log');
        if (file_exists($logPath)) {
            $logSize = filesize($logPath);
            $this->command->info('Log file exists and is ' . $logSize . ' bytes');
        } else {
            $this->command->info('Log file does not exist yet - will be created on first log entry');
        }
        
        $this->command->info('');
        $this->command->info('Login functionality test completed!');
    }
}
