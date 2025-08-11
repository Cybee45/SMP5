<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportRedirects\Redirector;

class LoginResponse implements Responsable
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $user = Auth::user();
        
        // Check if user is active
        if (!$user->is_active) {
            Auth::logout();
            return redirect()->route('filament.admin.auth.login')
                ->withErrors(['email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.']);
        }

        // Check if user can access panel
        if (!$user->canAccessPanel()) {
            Auth::logout();
            return redirect()->route('filament.admin.auth.login')
                ->withErrors(['email' => 'Anda tidak memiliki akses ke panel admin.']);
        }

        // Redirect to admin panel
        return redirect()->intended(filament()->getUrl());
    }
}
