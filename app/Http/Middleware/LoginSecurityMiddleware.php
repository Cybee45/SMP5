<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LoginSecurityMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('POST') && $request->routeIs('login')) {
            $this->handleLoginAttempt($request);
        }
        
        return $next($request);
    }

    /**
     * Handle login attempt security
     */
    private function handleLoginAttempt(Request $request): void
    {
        $email = $request->input('email');
        $ip = $request->ip();
        
        // Rate limiting per IP
        $ipKey = 'login_attempts_ip:' . $ip;
        if (RateLimiter::tooManyAttempts($ipKey, 5)) { // 5 attempts per hour
            Log::warning('Too many login attempts from IP', [
                'ip' => $ip,
                'email' => $email,
                'user_agent' => $request->userAgent()
            ]);
            
            // Block IP for 1 hour
            Cache::put('blocked_login_ip:' . $ip, true, 3600);
            
            abort(429, 'Terlalu banyak percobaan login. Coba lagi dalam 1 jam.');
        }
        
        // Rate limiting per email
        if ($email) {
            $emailKey = 'login_attempts_email:' . $email;
            if (RateLimiter::tooManyAttempts($emailKey, 3)) { // 3 attempts per hour per email
                Log::warning('Too many login attempts for email', [
                    'ip' => $ip,
                    'email' => $email,
                    'user_agent' => $request->userAgent()
                ]);
                
                abort(429, 'Terlalu banyak percobaan login untuk email ini. Coba lagi dalam 1 jam.');
            }
            
            RateLimiter::hit($emailKey, 3600); // 1 hour
        }
        
        // Check if IP is blocked
        if (Cache::has('blocked_login_ip:' . $ip)) {
            abort(403, 'IP Anda telah diblokir sementara karena aktivitas mencurigakan.');
        }
        
        RateLimiter::hit($ipKey, 3600); // 1 hour
        
        // Log all admin login attempts
        Log::info('Admin login attempt', [
            'ip' => $ip,
            'email' => $email,
            'user_agent' => $request->userAgent(),
            'timestamp' => now()
        ]);
    }
}
