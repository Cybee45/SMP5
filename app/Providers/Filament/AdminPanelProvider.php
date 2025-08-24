<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(\App\Filament\Pages\Auth\Login::class)
            ->brandName('CMS Sekolah')
            ->favicon('/favicon.ico')
            ->colors([
                'primary' => Color::Blue,
                'gray' => Color::Slate,
            ])
            ->renderHook(
                'panels::body.end',
                fn (): string => '<script src="' . asset('js/admin-session-manager.js') . '"></script>'
            )
            ->renderHook(
                'panels::head.end',
                fn (): string => '<meta name="csrf-token" content="' . csrf_token() . '">'
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->resources([
                // Home/Beranda Resources
                \App\Filament\Resources\HeroResource::class,
                \App\Filament\Resources\KeunggulanResource::class,
                \App\Filament\Resources\StatistikResource::class,
                \App\Filament\Resources\SectionKeunggulanResource::class,
                
                // About/Profil Resources
                \App\Filament\Resources\ProfilResource::class,
                \App\Filament\Resources\AboutHeroResource::class,
                \App\Filament\Resources\PrestasiAboutResource::class,
                \App\Filament\Resources\TimBirokrasiResource::class,
                \App\Filament\Resources\VisiMisiResource::class,
                
                // SPMB Resources
                \App\Filament\Resources\SpmhHeroResource::class,
                \App\Filament\Resources\SpmhContentResource::class,
                
                // Artikel & Content Resources
                \App\Filament\Resources\ArtikelResource::class,
                \App\Filament\Resources\KategoriArtikelResource::class,
                \App\Filament\Resources\KontakResource::class,
                
                // Media/Galeri Resources
                \App\Filament\Resources\MediaGaleriResource::class,
                \App\Filament\Resources\MediaHeroResource::class,
                \App\Filament\Resources\MediaVideoResource::class,
                
                // Footer Management Resources
                \App\Filament\Resources\FooterSettingResource::class,
                \App\Filament\Resources\SectionAkreditasiResource::class,
                
                // System Resources
                \App\Filament\Resources\UserResource::class,
                \App\Filament\Resources\RoleResource::class,
                \App\Filament\Resources\PermissionResource::class,
                \App\Filament\Resources\ProfileSettingsResource::class,
            ])
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
            \App\Filament\Widgets\QuickActionsWidget::class,
            \App\Filament\Widgets\KpiOverview::class,          // <-- pakai nama widget kustom kamu
            \App\Filament\Widgets\ContentOverviewChart::class,
            \App\Filament\Widgets\CMSGuideWidget::class,
            \App\Filament\Widgets\RecentActivityTable::class,
            ])

            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}