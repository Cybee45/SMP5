<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class BruteForceTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== BRUTE FORCE PROTECTION TESTING ===');
        
        // Reset user login attempts
        $user = User::where('email', 'admin@smp5sangatta.sch.id')->first();
        if ($user) {
            $user->update(['login_attempts' => 0, 'locked_until' => null]);
            $this->command->info('Reset user login attempts');
        }
        
        $this->command->info('Testing login brute force protection...');
        $this->command->info('');
        
        $failedAttempts = 0;
        $blockedAttempts = 0;
        
        // Try 7 failed login attempts
        for ($i = 1; $i <= 7; $i++) {
            try {
                $this->command->info("Attempt #$i: Trying invalid credentials...");
                
                // First get the login page to get CSRF token
                $loginPage = Http::get('http://127.0.0.1:8000/admin/login');
                
                if ($loginPage->status() !== 200) {
                    $this->command->error("Cannot access login page: " . $loginPage->status());
                    continue;
                }
                
                // Extract CSRF token (basic approach)
                $loginPageContent = $loginPage->body();
                
                // Try to login with wrong password
                $response = Http::asForm()->post('http://127.0.0.1:8000/admin/login', [
                    'email' => 'admin@smp5sangatta.sch.id',
                    'password' => 'wrongpassword' . $i,
                ]);
                
                if ($response->status() === 422 || $response->status() === 302) {
                    $failedAttempts++;
                    $this->command->info("   ❌ Login failed (Expected)");
                } elseif ($response->status() === 429) {
                    $blockedAttempts++;
                    $this->command->info("   🚫 Rate limited!");
                    break;
                } else {
                    $this->command->info("   Unexpected status: " . $response->status());
                }
                
                // Check user lock status
                $user->refresh();
                if ($user->isLocked()) {
                    $this->command->info("   🔒 User account is now locked until: " . $user->locked_until);
                    break;
                }
                
                $this->command->info("   Current login attempts: " . $user->login_attempts);
                
            } catch (\Exception $e) {
                $this->command->error("   Error: " . $e->getMessage());
            }
            
            // Small delay between attempts
            sleep(1);
        }
        
        $this->command->info('');
        $this->command->info('Brute Force Protection Results:');
        $this->command->info('Failed attempts made: ' . $failedAttempts);
        $this->command->info('Blocked attempts: ' . $blockedAttempts);
        
        // Check final user status
        $user->refresh();
        $this->command->info('Final user login attempts: ' . $user->login_attempts);
        $this->command->info('User locked: ' . ($user->isLocked() ? 'Yes' : 'No'));
        
        if ($user->isLocked()) {
            $this->command->info('✅ Account lockout protection is working!');
        } else {
            $this->command->info('❌ Account lockout may need attention.');
        }
        
        $this->command->info('');
        $this->command->info('Brute force test completed!');
    }
}
