<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class SecurityHeaderTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== SECURITY HEADERS TESTING ===');
        
        try {
            $response = Http::get('http://127.0.0.1:8000/admin');
            
            $headers = $response->headers();
            
            $this->command->info('Response Status: ' . $response->status());
            $this->command->info('');
            
            $securityHeaders = [
                'X-Frame-Options',
                'X-Content-Type-Options', 
                'X-XSS-Protection',
                'Referrer-Policy',
                'Content-Security-Policy',
                'Strict-Transport-Security',
                'Cache-Control',
                'Pragma'
            ];
            
            $this->command->info('Security Headers Check:');
            foreach ($securityHeaders as $header) {
                $value = $headers[$header][0] ?? 'NOT SET';
                $status = $value !== 'NOT SET' ? '✅' : '❌';
                $this->command->info($status . ' ' . $header . ': ' . $value);
            }
            
        } catch (\Exception $e) {
            $this->command->error('Error testing headers: ' . $e->getMessage());
        }
        
        $this->command->info('');
        $this->command->info('Security headers test completed!');
    }
}
