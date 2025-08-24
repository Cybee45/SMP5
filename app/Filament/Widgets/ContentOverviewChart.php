<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Services\DashboardService;

// ====== SESUAIKAN MODEL DI BAWAH INI DENGAN PROYEKMU ======
use App\Models\Artikel;
use App\Models\MediaGaleri;   // ganti ke App\Models\Galeri jika itu yang kamu pakai
use App\Models\MediaVideo;
// ===========================================================

class ContentOverviewChart extends ChartWidget
{
    // ChartWidget butuh STATIC heading di versi kamu
    protected static ?string $heading = 'Overview Konten CMS';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        // Dataset yang mau ditampilkan
        $configs = [
            ['label' => 'Artikel', 'model' => Artikel::class,     'date' => 'tanggal_publikasi'],
            ['label' => 'Galeri',  'model' => MediaGaleri::class, 'date' => 'tanggal'],
            ['label' => 'Video',   'model' => MediaVideo::class,  'date' => 'created_at'],
        ];

        // Try to get counts from service; if it fails, return a safe fallback.
        try {
            $r = DashboardService::multiMonthlyCounts($configs, monthsBack: 6);
        } catch (\Throwable $e) {
            // Fallback: build 6-month labels and zeroed datasets
            $labels = [];
            for ($i = 5; $i >= 0; $i--) {
                $labels[] = now()->subMonths($i)->format('M Y');
            }

            $colors = [
                'Artikel' => '#3b82f6', // biru
                'Galeri'  => '#10b981', // hijau
                'Video'   => '#f59e0b', // kuning
            ];

            $datasets = array_map(function ($cfg) use ($labels, $colors) {
                $color = $colors[$cfg['label']] ?? '#6366f1';
                return [
                    'label'           => $cfg['label'],
                    'data'            => array_fill(0, count($labels), 0),
                    'fill'            => false,
                    'tension'         => 0.35,
                    'borderWidth'     => 2,
                    'pointRadius'     => 3,
                    'borderColor'     => $color,
                    'backgroundColor' => $color,
                ];
            }, $configs);

            return [
                'datasets' => $datasets,
                'labels'   => $labels,
            ];
        }

        // Warna custom per dataset (Tailwind palette)
        $colors = [
            'Artikel' => '#3b82f6', // biru
            'Galeri'  => '#10b981', // hijau
            'Video'   => '#f59e0b', // kuning
        ];

        $rawDatasets = $r['datasets'] ?? [];
        $labels = $r['labels'] ?? [];

        $datasets = array_map(function ($ds) use ($colors) {
            $color = $colors[$ds['label']] ?? '#6366f1'; // fallback ungu
            return [
                'label'           => $ds['label'] ?? 'Data',
                'data'            => $ds['data'] ?? [],
                'fill'            => false,
                'tension'         => 0.35,
                'borderWidth'     => 2,
                'pointRadius'     => 3,
                'borderColor'     => $color,
                'backgroundColor' => $color,
            ];
        }, $rawDatasets);

        return [
            'datasets' => $datasets,
            'labels'   => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend'  => ['position' => 'bottom'],
                'tooltip' => ['mode' => 'index', 'intersect' => false],
            ],
            'interaction' => ['mode' => 'index', 'intersect' => false],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => ['precision' => 0],
                ],
            ],
        ];
    }
}
