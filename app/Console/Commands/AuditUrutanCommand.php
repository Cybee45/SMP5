<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AuditUrutanCommand extends Command
{
    protected $signature = 'audit:urutan 
        {--table=* : Batasi ke tabel tertentu (boleh diulang)}
        {--fix= : Perbaikan otomatis: clamp | renumber}
        {--dry : Dry-run; tampilkan apa yang akan terjadi tanpa update}';

    protected $description = 'Audit semua kolom "urutan" di database. Opsi --fix=clamp/renumber untuk perbaikan.';

    public function handle(): int
    {
        $schema = config('database.connections.'.config('database.default').'.database');

        // Cari semua kolom bernama "urutan"
        $rows = DB::select("
            SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE, IS_NULLABLE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_SCHEMA = ? AND COLUMN_NAME = 'urutan'
            ORDER BY TABLE_NAME
        ", [$schema]);

        if (empty($rows)) {
            $this->info('Tidak ditemukan kolom "urutan" di database.');
            return self::SUCCESS;
        }

        // Filter by --table
        $only = collect($this->option('table') ?: []);
        if ($only->isNotEmpty()) {
            $rows = array_values(array_filter($rows, fn($r) => $only->contains($r->TABLE_NAME)));
        }

        $fix = $this->option('fix'); // null|clamp|renumber
        $dry = (bool) $this->option('dry');

        $this->line('');
        $this->info('=== Audit kolom "urutan" ===');

        foreach ($rows as $col) {
            $table     = $col->TABLE_NAME;
            $dataType  = strtolower($col->DATA_TYPE);   // tinyint/smallint/mediumint/int/bigint/...
            $colType   = strtolower($col->COLUMN_TYPE); // contoh: int(11) unsigned
            $unsigned  = str_contains($colType, 'unsigned');

            // Hitung batas maksimum menurut tipe
            [$min, $max] = $this->boundsFor($dataType, $unsigned);

            // Ambil nilai max aktual & jumlah yang out-of-range
            $maxRow = DB::table($table)->selectRaw('MAX(`urutan`) AS m')->first();
            $maxVal = $maxRow?->m;

            $out     = DB::table($table)->where(function($q) use($min, $max){
                            $q->where('urutan', '>', $max)->orWhere('urutan', '<', $min);
                       })->count();

            $this->line('');
            $this->comment("[$table]");
            $this->line("  type : {$dataType}".($unsigned?' unsigned':''));
            $this->line("  bound: {$min} .. {$max}");
            $this->line("  dbMax: ".($maxVal ?? 'NULL'));
            $this->line("  out-of-range rows: $out");

            if ($out > 0 && $fix) {
                if ($fix === 'clamp') {
                    $this->warn("  FIX: clamp -> set <{$min} ke {$min}, >{$max} ke {$max}");
                    if (!$dry) {
                        DB::table($table)->where('urutan','<',$min)->update(['urutan'=>$min]);
                        DB::table($table)->where('urutan','>',$max)->update(['urutan'=>$max]);
                    }
                } elseif ($fix === 'renumber') {
                    $this->warn("  FIX: renumber -> urutkan ulang mulai 1 berdasarkan created_at,id");
                    if (!$dry) {
                        $this->renumber($table);
                    }
                }
                if ($dry) {
                    $this->info("  (dry-run) Tidak ada perubahan yang ditulis.");
                } else {
                    $this->info("  Selesai perbaikan tabel: {$table}");
                }
            }
        }

        $this->line('');
        $this->info('Audit selesai.');
        return self::SUCCESS;
    }

    /** Batas numerik menurut tipe kolom */
    private function boundsFor(string $type, bool $unsigned): array
    {
        // default ke INT
        $bounds = [
            'tinyint'   => $unsigned ? [0, 255] : [-128, 127],
            'smallint'  => $unsigned ? [0, 65535] : [-32768, 32767],
            'mediumint' => $unsigned ? [0, 16777215] : [-8388608, 8388607],
            'int'       => $unsigned ? [0, 4294967295] : [-2147483648, 2147483647],
            'bigint'    => $unsigned ? [0, 18446744073709551615] : [-9223372036854775808, 9223372036854775807],
        ];

        return $bounds[$type] ?? $bounds['int'];
    }

    /** Renomor urutan: 1..N berdasarkan created_at asc lalu id asc */
    private function renumber(string $table): void
    {
        $rows = DB::table($table)
            ->select('id')
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();

        $i = 1;
        foreach ($rows as $r) {
            DB::table($table)->where('id', $r->id)->update(['urutan' => $i++]);
        }
    }
}
