<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Hero;
use App\Models\AboutHero;
use App\Models\Keunggulan;
use App\Models\VisiMisi;
use App\Models\PrestasiAbout;
use App\Models\TimBirokrasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();
        
        $stats = [];
        
        // Stats untuk CMS Home (jika user bisa akses)
        if ($user->can('cms_home')) {
            $stats[] = Stat::make('Hero Home', Hero::count())
                ->description('Total konten hero homepage')
                ->descriptionIcon('heroicon-m-photo')
                ->color('success');
                
            $stats[] = Stat::make('Keunggulan', Keunggulan::where('aktif', true)->count())
                ->description('Item keunggulan aktif')
                ->descriptionIcon('heroicon-m-star')
                ->color('info');
        }
        
        // Stats untuk CMS About (jika user bisa akses)
        if ($user->can('cms_about')) {
            $stats[] = Stat::make('Hero About', AboutHero::count())
                ->description('Konten hero halaman about')
                ->descriptionIcon('heroicon-m-information-circle')
                ->color('warning');
                
            $stats[] = Stat::make('Tim Birokrasi', TimBirokrasi::where('aktif', true)->count())
                ->description('Anggota tim aktif')
                ->descriptionIcon('heroicon-m-users')
                ->color('danger');
        }
        
        // Stats untuk System Management (jika user bisa akses)
        if ($user->can('system_manage')) {
            $stats[] = Stat::make('Total Users', User::where('is_active', true)->count())
                ->description('Pengguna aktif sistem')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('gray');
        }
        
        return $stats;
    }
    
    public static function canView(): bool
    {
        return Auth::user()?->can('admin_access');
    }
}
