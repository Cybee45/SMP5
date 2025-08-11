<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SuspiciousActivityTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== SUSPICIOUS ACTIVITY DETECTION TESTING ===');
        
        // Clear previous blocks
        Cache::forget('blocked_ip:127.0.0.1');
        
        $suspiciousPayloads = [
            // SQL Injection patterns
            ['payload' => 'admin/users?id=1; DROP TABLE users;--', 'type' => 'SQL Injection'],
            ['payload' => "admin/users?name=' OR '1'='1", 'type' => 'SQL Injection'],
            ['payload' => 'admin/users?id=1 UNION SELECT * FROM users', 'type' => 'SQL Injection'],
            
            // XSS patterns
            ['payload' => 'admin/users?name=<script>alert(1)</script>', 'type' => 'XSS'],
            ['payload' => 'admin/users?comment=<img src=x onerror=alert(1)>', 'type' => 'XSS'],
            
            // Path Traversal
            ['payload' => 'admin/../../../etc/passwd', 'type' => 'Path Traversal'],
            ['payload' => 'admin/users?file=../../../etc/shadow', 'type' => 'Path Traversal'],
        ];
        
        $this->command->info('Testing suspicious activity detection...');
        $this->command->info('');
        
        $detectedCount = 0;
        $totalTests = count($suspiciousPayloads);
        
        foreach ($suspiciousPayloads as $index => $test) {
            try {
                $url = 'http://127.0.0.1:8000/' . $test['payload'];
                $this->command->info(($index + 1) . ". Testing {$test['type']}: " . $test['payload']);
                
                $response = Http::timeout(5)->get($url);
                
                if ($response->status() === 403) {
                    $this->command->info('   ✅ BLOCKED - Suspicious activity detected!');
                    $detectedCount++;
                } elseif ($response->status() === 404) {
                    $this->command->info('   ⚠️  404 Not Found (Normal for non-existent paths)');
                } else {
                    $this->command->info('   ❌ NOT BLOCKED - Status: ' . $response->status());
                }
                
                // Check if IP is blocked after suspicious activity
                if (Cache::has('blocked_ip:127.0.0.1')) {
                    $this->command->info('   ✅ IP has been blocked due to suspicious activity!');
                    break;
                }
                
            } catch (\Exception $e) {
                $this->command->error('   Error: ' . $e->getMessage());
            }
            
            $this->command->info('');
        }
        
        $this->command->info('Suspicious Activity Detection Results:');
        $this->command->info("Detected/Blocked: $detectedCount out of $totalTests tests");
        $this->command->info('IP Blocked: ' . (Cache::has('blocked_ip:127.0.0.1') ? 'Yes' : 'No'));
        
        if ($detectedCount > 0 || Cache::has('blocked_ip:127.0.0.1')) {
            $this->command->info('✅ Suspicious activity detection is working!');
        } else {
            $this->command->info('❌ Suspicious activity detection may need attention.');
        }
        
        $this->command->info('');
        $this->command->info('Suspicious activity test completed!');
    }
}
