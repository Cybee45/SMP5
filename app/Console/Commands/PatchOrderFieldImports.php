<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class PatchOrderFieldImports extends Command
{
    protected $signature = 'patch:orderfield {--dry : Preview only, do not write files}';
    protected $description = 'Fix all OrderField usages across Filament resources: import + static calls.';

    protected Filesystem $fs;

    public function __construct(Filesystem $fs)
    {
        parent::__construct();
        $this->fs = $fs;
    }

    public function handle(): int
    {
        $resourcesPath = app_path('Filament/Resources');
        if (!$this->fs->isDirectory($resourcesPath)) {
            $this->warn("Folder tidak ditemukan: {$resourcesPath}");
            return self::SUCCESS;
        }

        $finder = (new Finder())->files()->in($resourcesPath)->name('*.php');
        $dry = (bool) $this->option('dry');

        $backupRoot = storage_path('code-backups/orderfield/'.date('Ymd-His'));
        if (!$dry) {
            $this->fs->ensureDirectoryExists($backupRoot);
        }

        $total = 0; $changed = 0;

        foreach ($finder as $file) {
            $total++;
            $path = $file->getRealPath();
            $code = $this->fs->get($path);
            $orig = $code;

            // 1) Normalisasi static call yang keliru ke import-based call
            //    - App\Support\OrderField::make( ... )  -> OrderField::make( ... )
            //    - \App\Support\OrderField::make( ... ) -> OrderField::make( ... )
            $code = preg_replace(
                '/\\\\?App\\\\Support\\\\OrderField::make\s*\(/',
                'OrderField::make(',
                $code
            );

            // 2) Pastikan ada "use App\Support\OrderField;"
            $needsUse = !preg_match('/^use\s+App\\\\Support\\\\OrderField\s*;$/m', $code);

            // 3) Hilangkan import yang salah
            $code = preg_replace('/^use\s+App\\\\Filament\\\\Resources\\\\OrderField\s*;$/m', '', $code);
            $code = preg_replace('/^use\s+Filament\\\\Forms\\\\Components\\\\OrderField\s*;$/m', '', $code);

            // 4) Jika butuh, sisipkan "use App\Support\OrderField;" setelah blok namespace/use
            if ($needsUse) {
                // Pastikan file memang menggunakan OrderField::make(
                if (preg_match('/OrderField::make\s*\(/', $code)) {
                    $code = $this->injectUseImport($code, 'App\\Support\\OrderField');
                }
            }

            // 5) Bersihkan baris use ganda/blank beruntun
            $code = preg_replace("/\n{3,}/", "\n\n", $code);

            if ($code !== $orig) {
                $changed++;
                $this->info("✔ {$file->getRelativePathname()}");
                if (!$dry) {
                    // backup ke storage
                    $rel = str_replace(base_path().DIRECTORY_SEPARATOR, '', $path);
                    $backupPath = $backupRoot.DIRECTORY_SEPARATOR.str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $rel);
                    $this->fs->ensureDirectoryExists(dirname($backupPath));
                    $this->fs->put($backupPath, $orig);

                    // tulis versi yang sudah dipatching
                    $this->fs->put($path, $code);
                } else {
                    $this->line('   (dry-run, tidak menulis file)');
                }
            }
        }

        $this->newLine();
        $this->line("Dipindai: {$total} file");
        $this->line("Diubah  : {$changed} file");
        if (!$dry && $changed > 0) {
            $this->line("Backup  : {$backupRoot}");
        }

        return self::SUCCESS;
    }

    /**
     * Sisipkan "use Foo\Bar;" setelah blok use yang sudah ada,
     * atau setelah namespace bila belum ada satupun use.
     */
    private function injectUseImport(string $code, string $fqcn): string
    {
        // Jika sudah ada, kembalikan
        if (preg_match('/^use\s+'.preg_quote($fqcn, '/').'\s*;$/m', $code)) {
            return $code;
        }

        // Temukan namespace
        if (!preg_match('/^namespace\s+[^;]+;$/m', $code, $nsMatch, PREG_OFFSET_CAPTURE)) {
            // Tidak ada namespace? sisipkan di awal file setelah <?php
            return preg_replace('/^<\?php\s*/', "<?php\nuse {$fqcn};\n", $code, 1);
        }

        $nsEndPos = $nsMatch[0][1] + strlen($nsMatch[0][0]);

        // Cari blok use setelah namespace
        if (preg_match('/\G(\R(?:use\s+[^;]+;\R)+)/A', substr($code, $nsEndPos), $useMatch, 0)) {
            // Ada blok use: sisipkan di ujung blok
            $insertionPoint = $nsEndPos + strlen($useMatch[1]);
            return substr($code, 0, $insertionPoint)
                ."use {$fqcn};\n"
                .substr($code, $insertionPoint);
        }

        // Tidak ada blok use, sisipkan satu baris use setelah namespace + satu newline
        return substr($code, 0, $nsEndPos)
            ."\nuse {$fqcn};\n"
            .substr($code, $nsEndPos);
    }
}
