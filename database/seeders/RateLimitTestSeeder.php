<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cache;

class RateLimitTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== RATE LIMITING TESTING ===');
        
        // Clear previous rate limits
        RateLimiter::clear('admin-access:127.0.0.1');
        Cache::forget('blocked_ip:127.0.0.1');
        
        $this->command->info('Testing admin panel rate limiting...');
        
        $successCount = 0;
        $blockedCount = 0;
        
        // Test with multiple requests
        for ($i = 1; $i <= 70; $i++) {
            try {
                $response = Http::timeout(1)->get('http://127.0.0.1:8000/admin');
                
                if ($response->status() === 200) {
                    $successCount++;
                } elseif ($response->status() === 429) {
                    $blockedCount++;
                    $this->command->info("Request #$i: Rate limited (429)");
                    break;
                } else {
                    $this->command->info("Request #$i: Status " . $response->status());
                }
                
                if ($i % 10 === 0) {
                    $this->command->info("Completed $i requests...");
                }
                
                // Small delay to prevent overwhelming
                usleep(100000); // 0.1 second
                
            } catch (\Exception $e) {
                $this->command->error("Request #$i failed: " . $e->getMessage());
            }
        }
        
        $this->command->info('');
        $this->command->info('Rate Limiting Results:');
        $this->command->info('Successful requests: ' . $successCount);
        $this->command->info('Blocked requests: ' . $blockedCount);
        
        if ($blockedCount > 0) {
            $this->command->info('✅ Rate limiting is working correctly!');
        } else {
            $this->command->info('❌ Rate limiting may not be working as expected.');
        }
        
        $this->command->info('');
        $this->command->info('Rate limiting test completed!');
    }
}
