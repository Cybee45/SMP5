<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class CmsResourceFix extends Command
{
    protected $signature = 'cms:resource-fix 
        {--dry : Simulasi saja, tidak menulis file}
        {--show : Tampilkan detail perubahan}';

    protected $description = 'Perkuat Resource Filament: route key uuid_id, required kolom NOT NULL, hapus required kolom nullable, urutan keras, limit create.';

    protected bool $dry = false;
    protected bool $show = false;

    public function handle(): int
    {
        $this->dry  = (bool) $this->option('dry');
        $this->show = (bool) $this->option('show');

        $this->info('== CMS Resource Fix (Hard Mode) ==');

        $paths = array_merge(
            glob(base_path('app/Filament/Resources/*/*Resource.php')),
            glob(base_path('app/Filament/Resources/*Resource.php'))
        );

        if (empty($paths)) {
            $this->warn('Tidak ada Resource ditemukan di app/Filament/Resources.');
            return self::SUCCESS;
        }

        if (!config('cms.limits')) {
            $this->comment('Catatan: config cms.limits belum ada, default dipakai (artikels/media_galeris/galeris = 2000).');
        }

        foreach ($paths as $file) {
            $this->processResource($file);
        }

        $this->newLine();
        $this->info('Selesai. Jalankan tanpa --dry untuk menulis perubahan.');
        return self::SUCCESS;
    }

    protected function processResource(string $file): void
    {
        $code = File::get($file);
        $orig = $code;

        $modelFqn = $this->extractModelFqn($code, $file);
        if (!$modelFqn || !class_exists($modelFqn)) {
            $this->line("• Skip (model tidak ditemukan): ". $this->relative($file));
            return;
        }

        $table = null;
        try { $table = (new $modelFqn)->getTable(); } catch (\Throwable $e) {}

        $this->line("• Resource: {$this->relative($file)}  [model: {$modelFqn}, table: ".($table ?? '?')."]");

        if ($table && Schema::hasTable($table)) {
            // 1) Route key di Resource
            if (Schema::hasColumn($table, 'uuid_id')) {
                $code = $this->ensureResourceRouteKey($code, 'uuid_id');
            }

            // 2) Kerasin "urutan"
            if (Schema::hasColumn($table, 'urutan')) {
                $code = $this->ensureUrutanFieldRules($code, $modelFqn);
            }

            // 3) Required kolom NOT NULL (hanya bila field-nya ada di form)
            $notNullCols = $this->getNotNullColumns($table);
            $code = $this->addRequiredForNotNull($code, $notNullCols);

            // 4) Hapus required untuk kolom nullable (kalau sempat kepasang)
            $nullableCols = $this->getNullableColumns($table);
            $code = $this->removeRequiredForNullable($code, $nullableCols);

            // 5) Limit create untuk artikel/galeri
            if (in_array($table, ['artikels', 'media_galeris', 'galeris'])) {
                $code = $this->ensureCreateLimit($code, $table);
            }
        }

        // 6) Repair pass: rapikan required() yang nyasar di dalam argumen method
        $code = $this->repairMisplacedRequired($code);

        if ($code !== $orig) {
            if ($this->dry) {
                $this->comment('  [DRY] Ada perubahan yang akan diterapkan.');
            } else {
                File::put($file.'.bak', $orig);
                File::put($file, $code);
                $this->info('  [OK] Ditulis: '.$this->relative($file).' (backup: .bak)');
            }
        } else {
            $this->line('  [OK] Tidak perlu diubah.');
        }
    }

    /* -------------------- Model detection -------------------- */

    protected function extractModelFqn(string $code, string $file): ?string
    {
        $useMap = $this->parseUses($code);

        if (preg_match('/protected\s+static\s+\??string\s+\$model\s*=\s*([\\\\A-Za-z0-9_]+)::class\s*;/', $code, $m)) {
            $raw = $m[1]; // '\App\Models\Artikel' atau 'Artikel'
            return $this->resolveClassName($raw, $useMap);
        }

        // Fallback dari nama Resource
        $short = pathinfo($file, PATHINFO_FILENAME); // e.g. ArtikelResource
        $modelShort = preg_replace('/Resource$/', '', $short) ?: $short;
        $guess = '\\App\\Models\\' . $modelShort;
        return class_exists($guess) ? $guess : null;
    }

    protected function parseUses(string $code): array
    {
        $map = [];
        if (preg_match_all('/^use\s+([^;]+);/m', $code, $m)) {
            foreach ($m[1] as $fqn) {
                $fqn = trim($fqn);
                $short = $this->shortClass($fqn);
                $map[$short] = '\\' . ltrim($fqn, '\\');
            }
        }
        return $map;
    }

    protected function shortClass(string $fqn): string
    {
        $fqn = trim($fqn, '\\');
        $pos = strrpos($fqn, '\\');
        return $pos === false ? $fqn : substr($fqn, $pos + 1);
    }

    protected function resolveClassName(string $raw, array $useMap): string
    {
        if (str_starts_with($raw, '\\') || str_contains($raw, '\\')) {
            return '\\' . ltrim($raw, '\\');
        }
        return $useMap[$raw] ?? ('\\App\\Models\\' . $raw);
    }

    /* -------------------- Mutators / patches -------------------- */

    protected function ensureResourceRouteKey(string $code, string $key = 'uuid_id'): string
    {
        if (strpos($code, 'function getRecordRouteKeyName') !== false) {
            if ($this->show) $this->line('  - Route key method sudah ada.');
            return $code;
        }

        $insert = <<<PHP

    public static function getRecordRouteKeyName(): string
    {
        return '{$key}';
    }

PHP;
        $pos = strrpos($code, '}');
        if ($pos !== false) {
            $code = substr($code, 0, $pos) . $insert . "\n}" . substr($code, $pos + 1);
            $this->line('  + Menambahkan getRecordRouteKeyName() = '.$key);
        }
        return $code;
    }

    protected function ensureUrutanFieldRules(string $code, string $modelFqn): string
    {
        $pattern = '/TextInput::make\(\s*[\'"]urutan[\'"]\s*\)/i';
        if (!preg_match($pattern, $code)) {
            if ($this->show) $this->line('  - Komponen urutan tidak ditemukan (mungkin Hidden). Skip.');
            return $code;
        }

        // Chain yang wajib
        $add = [
            '->numeric()',
            '->minValue(1)',
            '->required()',
            "->default(fn () => (" . '\\' . ltrim($modelFqn, '\\') . "::max('urutan') ?? 0) + 1)",
        ];

        // Tambahkan chain yang belum ada (idempoten)
        $code = preg_replace_callback($pattern, function ($m) use ($code, $add) {
            $insertion = $m[0];
            $tail = $this->readAfter($code, $m[0], 400);
            foreach ($add as $chain) {
                if (strpos($tail, $chain) === false) {
                    $insertion .= $chain;
                }
            }
            return $insertion;
        }, $code);

        $this->line('  + Memastikan urutan: numeric + min(1) + required + default(max+1)');
        return $code;
    }

    protected function addRequiredForNotNull(string $code, array $notNullCols): string
    {
        // Kolom yang tidak relevan di form
        $skip = ['id','uuid_id','password','remember_token','email_verified_at','created_at','updated_at','deleted_at'];

        foreach ($notNullCols as $col) {
            if (in_array($col, $skip, true)) continue;

            // Tambahkan ->required() kalau komponen field-nya ada
            $regex = '/([A-Za-z0-9_\\\\]+)::make\(\s*[\'"]' . preg_quote($col, '/') . '[\'"]\s*\)(.*?)\)/s';
            $code = preg_replace_callback($regex, function ($m) use ($col) {
                $full = $m[0];
                if (preg_match('/->\s*required\s*\(\s*\)/', $full)) {
                    return $full; // sudah required
                }
                // sisipkan sebelum penutup komponen
                $new = preg_replace('/\)\s*$/', '->required())', $full);
                if ($new !== $full) {
                    $this->line("  + Menandai required() untuk kolom NOT NULL: {$col}");
                }
                return $new;
            }, $code);
        }
        return $code;
    }

    protected function getNotNullColumns(string $table): array
    {
        $db = DB::selectOne('select database() as db')->db ?? null;
        if (!$db) return [];

        $rows = DB::select("
            SELECT COLUMN_NAME, IS_NULLABLE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
        ", [$db, $table]);

        return collect($rows)
            ->filter(fn($r) => strtoupper($r->IS_NULLABLE ?? '') === 'NO')
            ->pluck('COLUMN_NAME')
            ->values()
            ->all();
    }

    protected function getNullableColumns(string $table): array
    {
        $db = DB::selectOne('select database() as db')->db ?? null;
        if (!$db) return [];

        $rows = DB::select("
            SELECT COLUMN_NAME, IS_NULLABLE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
        ", [$db, $table]);

        return collect($rows)
            ->filter(fn($r) => strtoupper($r->IS_NULLABLE ?? '') === 'YES')
            ->pluck('COLUMN_NAME')
            ->values()
            ->all();
    }

    protected function removeRequiredForNullable(string $code, array $nullableCols): string
    {
        foreach ($nullableCols as $col) {
            if (in_array($col, ['deleted_at','created_at','updated_at'])) continue;

            // Hapus ->required() pada field yang nullable
            $regex = '/([A-Za-z0-9_\\\\]+)::make\(\s*[\'"]' . preg_quote($col, '/') . '[\'"]\s*\)(.*?)\)/s';
            $code = preg_replace_callback($regex, function ($m) use ($col) {
                $full = $m[0];
                $new = preg_replace('/->\s*required\s*\(\s*\)/', '', $full);
                if ($new !== $full) {
                    $this->line("  - Menghapus required() (kolom nullable): {$col}");
                }
                return $new;
            }, $code);
        }
        return $code;
    }

    protected function ensureCreateLimit(string $code, string $table): string
    {
        if (strpos($code, 'function canCreate(') !== false || strpos($code, 'static function canCreate(') !== false) {
            if ($this->show) $this->line('  - canCreate() sudah ada.');
            return $code;
        }

        $mapKey = match ($table) {
            'artikels'      => 'artikels',
            'media_galeris' => 'media_galeris',
            'galeris'       => 'galeris',
            default         => null,
        };
        if (!$mapKey) return $code;

        $insert = <<<PHP

    public static function canCreate(): bool
    {
        \$limit = (int) config('cms.limits.{$mapKey}', 2000);
        try {
            \$count = (int) \\Illuminate\\Support\\Facades\\DB::table('{$table}')->count();
        } catch (\\Throwable \$e) {
            \$count = 0;
        }
        return \$count < \$limit;
    }

PHP;

        $pos = strrpos($code, '}');
        if ($pos !== false) {
            $code = substr($code, 0, $pos) . $insert . "\n}" . substr($code, $pos + 1);
            $this->line("  + Menambahkan canCreate() limit untuk {$table} (config key: cms.limits.{$mapKey})");
        }
        return $code;
    }

    /* -------------------- Repair helpers -------------------- */

    protected function repairMisplacedRequired(string $code): string
    {
        // Pindahkan required() yang nyasar di dalam argumen method ke luar.
        // Contoh: default(true->required()) => default(true)->required()
        //         minValue(1->required())   => minValue(1)->required()
        $patterns = [
            '/(default)\(\s*([^()]*?)\s*->\s*required\(\)\s*\)/',
            '/(minValue)\(\s*([^()]*?)\s*->\s*required\(\)\s*\)/',
            '/(maxLength)\(\s*([^()]*?)\s*->\s*required\(\)\s*\)/',
            '/(placeholder)\(\s*([^()]*?)\s*->\s*required\(\)\s*\)/',
        ];
        foreach ($patterns as $p) {
            $code = preg_replace($p, '$1($2)->required()', $code);
        }
        return $code;
    }

    protected function readAfter(string $haystack, string $token, int $len = 400): string
    {
        $pos = strpos($haystack, $token);
        if ($pos === false) return '';
        return substr($haystack, $pos, $len);
    }

    protected function relative(string $path): string
    {
        return str_replace(base_path() . DIRECTORY_SEPARATOR, '', $path);
    }
}
