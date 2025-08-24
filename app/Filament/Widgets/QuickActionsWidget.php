<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class QuickActionsWidget extends Widget
{
    protected static string $view = 'filament.widgets.quick-actions-widget';
    
    protected static ?int $sort = 1;
    
    protected int | string | array $columnSpan = 'full';
    
    public static function canView(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole(['admin', 'super-admin']) || $user->can('view_dashboard'));
    }
    
    protected function getViewData(): array
    {
        $user = Auth::user();
        $isSuperAdmin = $user->hasRole('super-admin');
        $isAdmin = $user->hasRole('admin');
        
        $actions = [];
        
        // Quick Actions untuk Content Management
        $actions['Konten Utama'] = [
            [
                'title' => 'Artikel Baru',
                'description' => 'Buat artikel berita sekolah',
                'icon' => 'heroicon-o-document-plus',
                'url' => route('filament.admin.resources.artikels.create'),
                'color' => 'success',
                'permission' => 'create_artikel'
            ],
            [
                'title' => 'Upload Media',
                'description' => 'Tambah foto galeri sekolah',
                'icon' => 'heroicon-o-photo',
                'url' => route('filament.admin.resources.media-galeris.create'),
                'color' => 'info',
                'permission' => 'create_media_galeri'
            ],
            [
                'title' => 'Video Baru',
                'description' => 'Tambah video dokumentasi',
                'icon' => 'heroicon-o-video-camera',
                'url' => route('filament.admin.resources.media-videos.create'),
                'color' => 'warning',
                'permission' => 'create_media_video'
            ]
        ];
        
        // Quick Actions untuk About Management
        if ($isAdmin || $isSuperAdmin) {
            $actions['Profil Sekolah'] = [
                [
                    'title' => 'Tim Birokrasi',
                    'description' => 'Kelola profil guru dan staf',
                    'icon' => 'heroicon-o-users',
                    'url' => route('filament.admin.resources.tim-birokrasis.index'),
                    'color' => 'purple',
                    'permission' => 'view_tim_birokrasi'
                ],
                [
                    'title' => 'Prestasi Sekolah',
                    'description' => 'Update pencapaian sekolah',
                    'icon' => 'heroicon-o-trophy',
                    'url' => route('filament.admin.resources.prestasi-abouts.index'),
                    'color' => 'yellow',
                    'permission' => 'view_prestasi_about'
                ]
            ];
        }
        
        // Quick Actions untuk Admin Management (Super Admin only)
        if ($isSuperAdmin) {
            $actions['Administrasi'] = [
                [
                    'title' => 'Kelola User',
                    'description' => 'Manajemen pengguna CMS',
                    'icon' => 'heroicon-o-user-group',
                    'url' => route('filament.admin.resources.users.index'),
                    'color' => 'gray',
                    'permission' => 'view_user'
                ],
                [
                    'title' => 'Pesan Kontak',
                    'description' => 'Lihat pesan dari website',
                    'icon' => 'heroicon-o-envelope',
                    'url' => route('filament.admin.resources.kontaks.index'),
                    'color' => 'red',
                    'permission' => 'view_kontak'
                ],
                [
                    'title' => 'Footer Setting',
                    'description' => 'Kelola konten footer',
                    'icon' => 'heroicon-o-document-text',
                    'url' => route('filament.admin.resources.footer-settings.index'),
                    'color' => 'indigo',
                    'permission' => 'view_footer_setting'
                ]
            ];
        }
        
        return ['actions' => $actions, 'user' => $user];
    }
}