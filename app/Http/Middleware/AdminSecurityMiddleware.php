<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminSecurityMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Rate Limiting untuk admin panel
        $this->handleRateLimit($request);
        
        // 2. IP Whitelist check (jika dikonfigurasi)
        $this->checkIPWhitelist($request);
        
        // 3. Suspicious Activity Detection
        $this->detectSuspiciousActivity($request);
        
        // 4. Session Security
        $this->enforceSessionSecurity($request);
        
        $response = $next($request);
        
        // 5. Security Headers
        $this->addSecurityHeaders($response);
        
        return $response;
    }

    /**
     * Handle rate limiting untuk admin panel
     */
    private function handleRateLimit(Request $request): void
    {
        $key = 'admin-access:' . $request->ip();
        
        // Rate limit: 60 requests per minute
        if (RateLimiter::tooManyAttempts($key, 60)) {
            Log::warning('Rate limit exceeded for admin panel', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl()
            ]);
            
            abort(429, 'Terlalu banyak permintaan. Coba lagi nanti.');
        }
        
        RateLimiter::hit($key, 60);
    }

    /**
     * Check IP Whitelist (optional)
     */
    private function checkIPWhitelist(Request $request): void
    {
        $allowedIPs = config('security.admin_ip_whitelist', []);
        
        if (!empty($allowedIPs) && !in_array($request->ip(), $allowedIPs)) {
            Log::alert('Unauthorized IP access attempt to admin panel', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl()
            ]);
            
            abort(403, 'Access denied from this IP address.');
        }
    }

    /**
     * Detect suspicious activity
     */
    private function detectSuspiciousActivity(Request $request): void
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        
        // Check for suspicious patterns
        $suspiciousPatterns = [
            'sql', 'union', 'select', 'drop', 'insert', 'update', 'delete',
            'script', 'javascript', 'vbscript', 'onload', 'onerror',
            '../', '..\\', '/etc/passwd', '/etc/shadow'
        ];
        
        $requestData = json_encode($request->all()) . $request->fullUrl();
        
        foreach ($suspiciousPatterns as $pattern) {
            if (stripos($requestData, $pattern) !== false) {
                Log::alert('Suspicious activity detected', [
                    'ip' => $ip,
                    'user_agent' => $userAgent,
                    'pattern' => $pattern,
                    'request_data' => $requestData
                ]);
                
                // Block IP for 1 hour
                Cache::put('blocked_ip:' . $ip, true, 3600);
                
                abort(403, 'Suspicious activity detected.');
            }
        }
        
        // Check if IP is already blocked
        if (Cache::has('blocked_ip:' . $ip)) {
            abort(403, 'Your IP has been temporarily blocked due to suspicious activity.');
        }
    }

    /**
     * Enforce session security
     */
    private function enforceSessionSecurity(Request $request): void
    {
        // Regenerate session ID every 30 minutes
        $lastRegeneration = session('last_regeneration', 0);
        if (time() - $lastRegeneration > 1800) { // 30 minutes
            $request->session()->regenerate();
            session(['last_regeneration' => time()]);
        }
        
        // Check for concurrent sessions
        if (Auth::check()) {
            $user = Auth::user();
            $currentSessionId = session()->getId();
            $lastSessionId = Cache::get('user_session:' . $user->id);
            
            if ($lastSessionId && $lastSessionId !== $currentSessionId) {
                Log::warning('Concurrent session detected', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'ip' => $request->ip()
                ]);
                
                // Optional: Force logout of previous session
                // Auth::logout();
                // abort(403, 'Your account is being used in another session.');
            }
            
            Cache::put('user_session:' . $user->id, $currentSessionId, 3600);
        }
    }

    /**
     * Add security headers
     */
    private function addSecurityHeaders(Response $response): void
    {
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline'; img-src 'self' data: https:; font-src 'self' https:; connect-src 'self'");
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');
    }
}
