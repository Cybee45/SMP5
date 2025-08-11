<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class LoginSecurityListener
{
    /**
     * Handle successful login events.
     */
    public function handleLogin(Login $event): void
    {
        $user = $event->user;
        $ip = Request::ip();
        
        // Record login in user model
        $user->recordLogin($ip);
        
        // Log successful login
        Log::info('Successful admin login', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $ip,
            'user_agent' => Request::userAgent(),
            'timestamp' => now(),
            'role' => $user->roles->pluck('name')->join(', ')
        ]);
        
        // Check for unusual login patterns
        $this->checkUnusualActivity($user, $ip);
    }

    /**
     * Handle failed login events.
     */
    public function handleFailed(Failed $event): void
    {
        $credentials = $event->credentials;
        $ip = Request::ip();
        
        Log::warning('Failed admin login attempt', [
            'email' => $credentials['email'] ?? 'unknown',
            'ip' => $ip,
            'user_agent' => Request::userAgent(),
            'timestamp' => now()
        ]);
        
        // If user exists, increment login attempts
        if (isset($credentials['email'])) {
            $user = \App\Models\User::where('email', $credentials['email'])->first();
            if ($user) {
                $user->incrementLoginAttempts();
            }
        }
    }

    /**
     * Handle logout events.
     */
    public function handleLogout(Logout $event): void
    {
        $user = $event->user;
        $ip = Request::ip();
        
        Log::info('User logout', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $ip,
            'timestamp' => now()
        ]);
    }

    /**
     * Check for unusual login activity
     */
    private function checkUnusualActivity($user, $ip): void
    {
        // Check if login from different IP than last time
        if ($user->last_login_ip && $user->last_login_ip !== $ip) {
            Log::alert('Login from different IP detected', [
                'user_id' => $user->id,
                'email' => $user->email,
                'previous_ip' => $user->last_login_ip,
                'current_ip' => $ip,
                'timestamp' => now()
            ]);
        }
        
        // Check if login outside business hours (optional)
        $currentHour = now()->hour;
        if ($currentHour < 6 || $currentHour > 22) { // Outside 6 AM - 10 PM
            Log::warning('Login outside business hours', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $ip,
                'hour' => $currentHour,
                'timestamp' => now()
            ]);
        }
    }
}
