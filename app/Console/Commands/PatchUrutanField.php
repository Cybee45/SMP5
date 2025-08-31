<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class PatchUrutanField extends Command
{
    protected $signature   = 'patch:urutan-field {--dry : Pratinjau perubahan tanpa menulis file}';
    protected $description = 'Ganti TextInput::make("urutan") menjadi OrderField::make(<table>) di semua Filament Resource';

    public function __construct(private Filesystem $files)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $resourceDir = app_path('Filament/Resources');
        $backupBase  = storage_path('patch_backups/urutan');

        if (!$this->files->isDirectory($resourceDir)) {
            $this->warn("Folder $resourceDir tidak ditemukan.");
            return self::SUCCESS;
        }

        $phpFiles = collect($this->files->allFiles($resourceDir))
            ->filter(fn ($f) => Str::endsWith($f->getFilename(), '.php'));

        if ($phpFiles->isEmpty()) {
            $this->info('Tidak ada file resource.');
            return self::SUCCESS;
        }

        $dry     = (bool) $this->option('dry');
        $patched = 0;

        foreach ($phpFiles as $file) {
            $path = $file->getPathname();
            $code = $this->files->get($path);

            if (!preg_match("/TextInput::make\((['\"])urutan\\1\)/", $code)) {
                continue;
            }

            // cari model
            if (!preg_match('/protected\s+static\s+\?\s*string\s+\$model\s*=\s*([^;]+)::class\s*;/', $code, $m)) {
                $this->warn("[$path] Tidak menemukan properti \$model. Lewati.");
                continue;
            }
            $modelToken = trim($m[1], " \t\n\r\0\x0B\\");

            $aliasMap = $this->buildAliasMap($code);
            $fqcn     = $this->resolveModelFqcn($modelToken, $aliasMap);

            if (!$fqcn || !class_exists($fqcn)) {
                $fallback = 'App\\Models\\' . ltrim($modelToken, '\\');
                if (class_exists($fallback)) {
                    $fqcn = $fallback;
                }
            }

            if (!$fqcn || !class_exists($fqcn)) {
                $this->warn("[$path] Gagal resolve model [$modelToken]");
                continue;
            }

            try {
                $model = app($fqcn);
                $table = $model->getTable();
            } catch (\Throwable $e) {
                $this->warn("[$path] Gagal instantiate $fqcn: {$e->getMessage()}");
                continue;
            }

            $before = $code;

            if (!Str::contains($code, 'use App\\Support\\OrderField;')) {
                $code = preg_replace(
                    '/(^\s*namespace\s+[^;]+;\s*)/m',
                    "$0\nuse App\\Support\\OrderField;",
                    $code,
                    1
                );
            }

            $code = preg_replace(
                "/TextInput::make\((['\"])urutan\\1\)/",
                "OrderField::make('{$table}', 'Urutan')",
                $code
            );

            if ($code === $before) {
                continue;
            }

            $patched++;

            if ($dry) {
                $this->line("DRY: akan patch => $path (tabel: $table)");
            } else {
                // path backup: storage/patch_backups/urutan/...
                $relPath  = Str::after($path, base_path() . DIRECTORY_SEPARATOR);
                $backupTo = $backupBase . DIRECTORY_SEPARATOR . $relPath . '.bak';

                $this->files->ensureDirectoryExists(dirname($backupTo));
                $this->files->put($backupTo, $before);

                $this->files->put($path, $code);
                $this->info("Patched: $path (backup di $backupTo)");
            }
        }

        $this->info(($dry ? 'Pratinjau ' : '') . "selesai: $patched file diproses.");
        return self::SUCCESS;
    }

    private function buildAliasMap(string $code): array
    {
        $map = [];
        if (preg_match_all('/^use\s+App\\\\Models\\\\([A-Za-z0-9_\\\\]+)(?:\s+as\s+([A-Za-z0-9_]+))?;/m', $code, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $classPath = $m[1];
                $fqcn = 'App\\Models\\' . $classPath;
                $short = Str::afterLast($classPath, '\\');
                $map[$short] = $fqcn;
                if (!empty($m[2])) {
                    $map[$m[2]] = $fqcn;
                }
            }
        }
        return $map;
    }

    private function resolveModelFqcn(string $token, array $aliasMap): ?string
    {
        if (str_contains($token, '\\')) return ltrim($token, '\\');
        if (isset($aliasMap[$token])) return $aliasMap[$token];
        return 'App\\Models\\' . $token;
    }
}
