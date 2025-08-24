<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Artikel;
use App\Models\MediaGaleri; // ganti ke App\Models\Galeri jika itu yang kamu pakai
use App\Models\MediaVideo;
use App\Models\Pengumuman;
use App\Models\PrestasiAbout;
use App\Services\DashboardService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KpiOverview extends BaseWidget
{
    // HARUS non-static
    protected ?string $heading = 'Ringkasan';

    // ❗ Kembalikan int, bukan array
    protected function getColumns(): int
    {
        return 3; // tampilkan 3 kartu per baris
    }

    protected function getStats(): array
    {
        $totalUser        = DashboardService::safeCount(User::class);
        $artikelBulanIni  = DashboardService::countPublishedThisMonth(Artikel::class, 'tanggal_publikasi');
        $galeriBulanIni   = DashboardService::countPublishedThisMonth(MediaGaleri::class, 'tanggal');
        $videoAktif       = DashboardService::safeCount(MediaVideo::class, ['aktif' => 1]);
        $pengumumanAktif  = DashboardService::countActiveAnnouncements(Pengumuman::class);
        $prestasiAktif    = DashboardService::safeCount(PrestasiAbout::class, ['aktif' => 1]);

        return [
            Stat::make('Total User', number_format($totalUser, 0, ',', '.'))
                ->description('Semua akun')->icon('heroicon-o-users'),

            Stat::make('Artikel (bulan ini)', number_format($artikelBulanIni, 0, ',', '.'))
                ->description('Terbit bulan berjalan')->icon('heroicon-o-newspaper'),

            Stat::make('Galeri (bulan ini)', number_format($galeriBulanIni, 0, ',', '.'))
                ->description('Foto baru bulan ini')->icon('heroicon-o-photo'),

            Stat::make('Video Aktif', number_format($videoAktif, 0, ',', '.'))
                ->description('Di halaman media')->icon('heroicon-o-video-camera'),

            Stat::make('Pengumuman Aktif', number_format($pengumumanAktif, 0, ',', '.'))
                ->description('Belum berakhir')->icon('heroicon-o-megaphone'),

            Stat::make('Prestasi Aktif', number_format($prestasiAktif, 0, ',', '.'))
                ->description('Tampil di About/Prestasi')->icon('heroicon-o-trophy'),
        ];
    }
}
