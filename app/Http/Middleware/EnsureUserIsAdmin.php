<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            Log::warning('Unauthorized access attempt to admin panel', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'url' => $request->fullUrl()
            ]);
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if account is locked
        if ($user->isLocked()) {
            Auth::logout();
            Log::warning('Locked account tried to access admin panel', [
                'user_id' => $user->id,
                'username' => $user->username,
                'ip' => $request->ip(),
                'locked_until' => $user->locked_until
            ]);
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda dikunci hingga ' . $user->locked_until->format('d/m/Y H:i') . '. Silakan hubungi administrator.',
            ]);
        }

        // Check if account is active
        if (!$user->is_active) {
            Auth::logout();
            Log::warning('Inactive account tried to access admin panel', [
                'user_id' => $user->id,
                'username' => $user->username,
                'ip' => $request->ip()
            ]);
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
            ]);
        }

        // Check if user has admin access
        $canAccess = $user->canAccessPanel();
        $isActive = $user->is_active;
        $isAdmin = $user->isAdmin();
        $isLocked = $user->isLocked();
        $userRoles = $user->roles->pluck('name')->toArray();
        
        Log::info('Admin Access Check:', [
            'user_id' => $user->id,
            'username' => $user->username,
            'is_active' => $isActive,
            'isAdmin()' => $isAdmin,
            'isLocked()' => $isLocked,
            'canAccessPanel()' => $canAccess,
            'roles' => $userRoles,
            'hasRole_admin' => $user->hasRole('admin'),
            'hasRole_super_admin' => $user->hasRole('super_admin')
        ]);
        
        if (!$canAccess) {
            Log::alert('Non-admin user tried to access admin panel', [
                'user_id' => $user->id,
                'username' => $user->username,
                'ip' => $request->ip(),
                'roles' => $userRoles
            ]);
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Check if password change is required
        if ($user->force_password_change || $user->needsPasswordChange()) {
            Log::info('User required to change password', [
                'user_id' => $user->id,
                'username' => $user->username,
                'force_change' => $user->force_password_change,
                'password_age' => $user->password_changed_at ? $user->password_changed_at->diffInDays() : 'unknown'
            ]);
            
            // Redirect to password change page (implement this route)
            // return redirect()->route('admin.change-password');
        }

        return $next($request);
    }
}
