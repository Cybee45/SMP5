<?php

namespace App\Services;

use Illuminate\Support\Facades\Schema;

class DashboardService
{
    public static function safeCount(string $modelClass, array $where = []): int
    {
        $model = new $modelClass;
        $q = $modelClass::query();

        foreach ($where as $col => $val) {
            if (Schema::hasColumn($model->getTable(), $col)) {
                $q->where($col, $val);
            }
        }
        return (int) $q->count();
    }

    public static function countPublishedThisMonth(string $modelClass, string $preferredDateColumn = 'created_at'): int
    {
        $model = new $modelClass;
        $table = $model->getTable();

        $start = now()->startOfMonth();
        $q = $modelClass::query();

        if (Schema::hasColumn($table, $preferredDateColumn)) {
            $q->whereBetween($preferredDateColumn, [$start, now()]);
        } elseif (Schema::hasColumn($table, 'created_at')) {
            $q->whereBetween('created_at', [$start, now()]);
        } else {
            return 0;
        }
        return (int) $q->count();
    }

    public static function countActiveAnnouncements(string $modelClass): int
    {
        $model = new $modelClass;
        $table = $model->getTable();
        $q = $modelClass::query();

        if (Schema::hasColumn($table, 'status')) {
            $q->where('status', 'aktif');
        }
        if (Schema::hasColumn($table, 'tanggal_berakhir')) {
            $q->where(function ($qq) {
                $qq->whereNull('tanggal_berakhir')
                   ->orWhere('tanggal_berakhir', '>=', now());
            });
        }
        return (int) $q->count();
    }

    // ... tetap isi file yang lama

public static function multiMonthlyCounts(array $configs, int $monthsBack = 6): array
{
    // $configs: [['label' => 'Artikel', 'model' => \App\Models\Artikel::class, 'date' => 'tanggal_publikasi'], ...]
    $labels = [];
    $months = [];
    for ($i = $monthsBack - 1; $i >= 0; $i--) {
        $dt = now()->subMonths($i);
        $labels[] = $dt->isoFormat('MMM YY');
        $months[] = $dt->format('Y-m');
    }

    $datasets = [];
    foreach ($configs as $cfg) {
        $modelClass = $cfg['model'];
        $preferred  = $cfg['date'] ?? 'created_at';

        /** @var \Illuminate\Database\Eloquent\Model $m */
        $m = new $modelClass;
        $table = $m->getTable();
        $dateCol = \Schema::hasColumn($table, $preferred) ? $preferred : (\Schema::hasColumn($table, 'created_at') ? 'created_at' : null);

        // Kalau tidak ada kolom tanggal sama sekali, isi nol
        if (!$dateCol) {
            $datasets[] = [
                'label' => $cfg['label'],
                'data'  => array_fill(0, $monthsBack, 0),
            ];
            continue;
        }

        $rows = \DB::table($table)
            ->selectRaw("DATE_FORMAT($table.$dateCol, '%Y-%m') as ym, COUNT(*) as cnt")
            ->where($dateCol, '>=', now()->startOfMonth()->subMonths($monthsBack - 1))
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym');

        $series = [];
        foreach ($months as $ym) {
            $series[] = (int) ($rows[$ym]->cnt ?? 0);
        }

        $datasets[] = [
            'label' => $cfg['label'],
            'data'  => $series,
        ];
    }

    return compact('labels', 'datasets');
}

}
