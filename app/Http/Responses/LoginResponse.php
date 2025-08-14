<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as Responsable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportRedirects\Redirector;
use Filament\Notifications\Notification;

class LoginResponse implements Responsable
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $user = Auth::user();
        
        // Check if user is active
        if (!$user->is_active) {
            Auth::logout();
            
            Notification::make()
                ->title('Akun Tidak Aktif')
                ->body('Akun Anda tidak aktif. Silakan hubungi administrator.')
                ->danger()
                ->send();
                
            return redirect()->route('filament.admin.auth.login');
        }

        // Check if user can access panel
        if (!$user->canAccessPanel()) {
            Auth::logout();
            
            Notification::make()
                ->title('Akses Ditolak')
                ->body('Anda tidak memiliki akses ke panel admin.')
                ->danger()
                ->send();
                
            return redirect()->route('filament.admin.auth.login');
        }

        // Redirect to admin panel
        return redirect()->intended(filament()->getUrl());
    }
}
