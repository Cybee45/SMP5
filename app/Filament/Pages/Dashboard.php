<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    
    protected static string $view = 'filament.pages.dashboard';

    public function getTitle(): string
    {
        return 'Dashboard CMS';
    }

    public function getHeading(): string
    {
        return 'Selamat Datang di CMS Sekolah';
    }

    public function getSubheading(): string
    {
        $user = Auth::user();
        $greeting = $this->getGreeting();
        
        return "{$greeting}, {$user?->name}! Kelola konten website sekolah dengan mudah.";
    }

    private function getGreeting(): string
    {
        $hour = now()->hour;
        
        if ($hour < 12) {
            return 'Selamat Pagi';
        } elseif ($hour < 15) {
            return 'Selamat Siang';
        } elseif ($hour < 18) {
            return 'Selamat Sore';
        } else {
            return 'Selamat Malam';
        }
    }
}
