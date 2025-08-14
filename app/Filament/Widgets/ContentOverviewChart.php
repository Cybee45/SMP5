<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Hero;
use App\Models\AboutHero;
use App\Models\Keunggulan;
use App\Models\TimBirokrasi;
use Illuminate\Support\Facades\Auth;

class ContentOverviewChart extends ChartWidget
{
    protected static ?string $heading = 'Overview Konten CMS';
    
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $user = Auth::user();
        
        $labels = [];
        $data = [];
        $colors = [];
        
        if ($user->can('cms_home')) {
            $labels[] = 'Hero Home';
            $data[] = Hero::count();
            $colors[] = '#10B981';
            
            $labels[] = 'Keunggulan';
            $data[] = Keunggulan::count();
            $colors[] = '#3B82F6';
        }
        
        if ($user->can('cms_about')) {
            $labels[] = 'Hero About';
            $data[] = AboutHero::count();
            $colors[] = '#F59E0B';
            
            $labels[] = 'Tim Birokrasi';
            $data[] = TimBirokrasi::count();
            $colors[] = '#EF4444';
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Konten',
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderColor' => $colors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
    
    public static function canView(): bool
    {
        $user = Auth::user();
        return $user && ($user->can('cms_home') || $user->can('cms_about'));
    }
}
