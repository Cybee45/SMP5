<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class CMSGuideWidget extends Widget
{
    protected static string $view = 'filament.widgets.cms-guide-widget';
    
    protected static ?int $sort = 3;
    
    public static function canView(): bool
    {
        return Auth::user()?->can('admin_access');
    }
    
    protected function getViewData(): array
    {
        $user = Auth::user();
        
        $guides = [];
        
        if ($user->can('cms_home')) {
            $guides['CMS Home'] = [
                'Hero Home' => 'Kelola banner utama homepage',
                'Keunggulan' => 'Kelola daftar keunggulan sekolah',
                'Statistik' => 'Kelola angka-angka prestasi sekolah',
                'Section Keunggulan' => 'Kelola header section keunggulan'
            ];
        }
        
        if ($user->can('cms_about')) {
            $guides['CMS About'] = [
                'Hero About' => 'Kelola banner halaman tentang kami',
                'Visi & Misi' => 'Kelola visi dan misi sekolah',
                'Prestasi Sekolah' => 'Kelola daftar prestasi sekolah',
                'Tim Birokrasi' => 'Kelola profil tim birokrasi sekolah'
            ];
        }
        
        if ($user->can('system_manage')) {
            $guides['Manajemen Sistem'] = [
                'Pengguna' => 'Kelola akun pengguna sistem',
                'Role' => 'Kelola peran dan permission'
            ];
        }
        
        return ['guides' => $guides];
    }
}
