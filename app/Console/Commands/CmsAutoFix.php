<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;

class CmsAutoFix extends Command
{
    protected $signature = 'cms:auto-fix 
        {--dry : Simulasi saja (tanpa menulis perubahan)} 
        {--fix-schema : Perbaiki skema opsional (mis. tambah kolom gambar_wave)}
        {--months=6 : Periode default yang mungkin dipakai kalkulasi lain ke depan}';

    protected $description = 'Auto-fix data & inkonsistensi umum CMS (urutan, uuid_id, tanggal publish, deskripsi, dll.)';

    protected bool $dry = false;

    public function handle(): int
    {
        $this->dry = (bool) $this->option('dry');
        $fixSchema = (bool) $this->option('fix-schema');

        $row = DB::selectOne('select database() as db');
        $dbName = $row->db ?? null;
        if (!$dbName) {
            $this->error('Tidak dapat membaca nama database aktif.');
            return self::FAILURE;
        }

        $this->info('== CMS Auto Fix ==');
        $this->line("Database: <info>{$dbName}</info>");
        if ($this->dry) {
            $this->comment('Mode: DRY RUN (simulasi, tanpa menulis perubahan)');
        }
        if ($fixSchema) {
            $this->comment('Mode: FIX SCHEMA (akan menambah kolom tertentu bila dibutuhkan)');
        }

        // 1) Perbaiki semua tabel yang punya kolom `uuid_id`
        $uuidTables = $this->tablesHavingColumn($dbName, 'uuid_id');
        foreach ($uuidTables as $table) {
            $this->fixUuidId($table);
        }

        // 2) Perbaiki semua tabel yang punya kolom `urutan`
        $urutanTables = $this->tablesHavingColumn($dbName, 'urutan');
        foreach ($urutanTables as $table) {
            $this->fixUrutan($table);
        }

        // 3) Khusus tabel-tabel yang sering bermasalah
        $this->fixArtikels();                 // tanggal_publikasi & kategori (info)
        $this->fixHeroBlogs();                // deskripsi & urutan
        $this->fixMediaHeroes($fixSchema);    // subjudul ok, tambah gambar_wave (opsional/adaptif)
        $this->fixSpmbHeroes();               // uuid_id
        $this->fixSpmbContents();             // konten minimal, urutan
        $this->fixKontaks();                  // urutan (generic)
        $this->fixGaleriVideo();              // media_galeris/galeris, media_videos
        $this->fixKeunggulanPrestasi();       // keunggulans / prestasi_abouts

        $this->newLine();
        $this->info('Selesai. Cek kembali dashboard & form. Saranku: tambah validasi di Resource agar kasus serupa tidak terulang.');

        return self::SUCCESS;
    }

    /** ===================== Helpers ===================== */

    protected function tablesHavingColumn(string $dbName, string $column): array
    {
        $rows = DB::select("
            SELECT TABLE_NAME AS t 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_SCHEMA = ? AND COLUMN_NAME = ?
        ", [$dbName, $column]);

        return collect($rows)->pluck('t')->all();
    }

    protected function fixUuidId(string $table): void
    {
        if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'uuid_id')) return;

        $count = DB::table($table)->whereNull('uuid_id')->orWhere('uuid_id', '')->count();
        if ($count === 0) {
            $this->line("[$table] uuid_id: OK");
            return;
        }

        $this->warn("[$table] Mengisi uuid_id kosong: {$count} baris");
        if ($this->dry) return;

        DB::table($table)
            ->whereNull('uuid_id')
            ->orWhere('uuid_id', '')
            ->orderBy('id')
            ->select('id')
            ->chunkById(200, function ($rows) use ($table) {
                foreach ($rows as $row) {
                    DB::table($table)->where('id', $row->id)->update(['uuid_id' => (string) Str::uuid()]);
                }
            });
    }

    protected function fixUrutan(string $table): void
    {
        if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'urutan')) return;

        $nullCount = DB::table($table)->whereNull('urutan')->count();
        if ($nullCount === 0) {
            $this->line("[$table] urutan: OK (tidak ada NULL)");
            return;
        }

        $max = (int) (DB::table($table)->max('urutan') ?? 0);
        $this->warn("[$table] Memperbaiki urutan NULL: {$nullCount} baris (start dari " . ($max + 1) . ")");
        if ($this->dry) return;

        DB::table($table)
            ->whereNull('urutan')
            ->orderBy('id')
            ->select('id')
            ->chunkById(200, function ($rows) use ($table, &$max) {
                foreach ($rows as $row) {
                    $max++;
                    DB::table($table)->where('id', $row->id)->update(['urutan' => $max]);
                }
            });
    }

    protected function fixArtikels(): void
    {
        $table = 'artikels';
        if (!Schema::hasTable($table)) return;

        // tanggal_publikasi Wajib: isi dari created_at bila NULL, else NOW()
        if (Schema::hasColumn($table, 'tanggal_publikasi')) {
            $cnt = DB::table($table)->whereNull('tanggal_publikasi')->count();
            if ($cnt > 0) {
                $this->warn("[artikels] Mengisi tanggal_publikasi null: {$cnt}");
                if (!$this->dry) {
                    DB::table($table)
                        ->whereNull('tanggal_publikasi')
                        ->update(['tanggal_publikasi' => DB::raw('COALESCE(created_at, NOW())')]);
                }
            } else {
                $this->line('[artikels] tanggal_publikasi: OK');
            }
        }

        // kategori wajib? beri peringatan (tak diubah otomatis)
        if (Schema::hasColumn($table, 'kategori_id')) {
            $cnt = DB::table($table)->whereNull('kategori_id')->count();
            if ($cnt > 0) {
                $this->warn("[artikels] kategori_id null: {$cnt}. (Tidak diubah otomatis; saranku set default kategori 'Umum' di aplikasi)");
            }
        }
    }

    protected function fixHeroBlogs(): void
    {
        $table = 'hero_blogs';
        if (!Schema::hasTable($table)) return;

        // deskripsi Wajib → isi placeholder bila null/empty
        if (Schema::hasColumn($table, 'deskripsi')) {
            $cnt = DB::table($table)->whereNull('deskripsi')->orWhere('deskripsi', '')->count();
            if ($cnt > 0) {
                $this->warn("[hero_blogs] Mengisi deskripsi kosong: {$cnt}");
                if (!$this->dry) {
                    DB::table($table)
                        ->whereNull('deskripsi')
                        ->orWhere('deskripsi', '')
                        ->update(['deskripsi' => '-']);
                }
            } else {
                $this->line('[hero_blogs] deskripsi: OK');
            }
        }

        // urutan: handled generic
    }

    protected function fixMediaHeroes(bool $fixSchema): void
    {
        $table = 'media_heroes';
        if (!Schema::hasTable($table)) return;

        // Tambahkan kolom gambar_wave bila diminta & belum ada — adaptif (tanpa maksa after kolom yang tidak ada)
        if ($fixSchema && !Schema::hasColumn($table, 'gambar_wave')) {
            $this->warn('[media_heroes] Menambah kolom gambar_wave (nullable)');

            if (!$this->dry) {
                // Cari kolom yang ada untuk "after"
                $candidates = ['gambar', 'gambar_globe', 'subjudul', 'judul', 'updated_at', 'created_at', 'id'];
                $afterCol = null;
                foreach ($candidates as $c) {
                    if (Schema::hasColumn($table, $c)) { $afterCol = $c; break; }
                }

                Schema::table($table, function (Blueprint $t) use ($afterCol) {
                    $col = $t->string('gambar_wave', 2048)->nullable();
                    if ($afterCol) {
                        $col->after($afterCol);
                    }
                });
            }

            $this->line('[media_heroes] Kolom gambar_wave ditambahkan.');
        }

        // subjudul boleh null; urutan handled generic
    }

    protected function fixSpmbHeroes(): void
    {
        $table = 'spmh_heroes';
        if (!Schema::hasTable($table)) return;

        if (Schema::hasColumn($table, 'uuid_id')) {
            $cnt = DB::table($table)->whereNull('uuid_id')->orWhere('uuid_id', '')->count();
            if ($cnt > 0) {
                $this->warn("[spmh_heroes] Mengisi uuid_id kosong: {$cnt}");
                if (!$this->dry) {
                    DB::table($table)
                        ->whereNull('uuid_id')
                        ->orWhere('uuid_id', '')
                        ->orderBy('id')
                        ->select('id')
                        ->chunkById(200, function ($rows) use ($table) {
                            foreach ($rows as $row) {
                                DB::table($table)->where('id', $row->id)->update(['uuid_id' => (string) Str::uuid()]);
                            }
                        });
                }
            } else {
                $this->line('[spmh_heroes] uuid_id: OK');
            }
        }
    }

    protected function fixSpmbContents(): void
    {
        $table = 'spmh_contents';
        if (!Schema::hasTable($table)) return;

        // deskripsi boleh null: tidak dipaksa
        // urutan handled generic

        // jika 'konten' NOT NULL tapi kosong → isi placeholder ringan
        if (Schema::hasColumn($table, 'konten')) {
            $cnt = DB::table($table)->whereNull('konten')->orWhere('konten', '')->count();
            if ($cnt > 0) {
                $this->warn("[spmh_contents] Mengisi konten kosong: {$cnt}");
                if (!$this->dry) {
                    DB::table($table)
                        ->whereNull('konten')
                        ->orWhere('konten', '')
                        ->update(['konten' => '-']);
                }
            } else {
                $this->line('[spmh_contents] konten: OK');
            }
        }
    }

    protected function fixKontaks(): void
    {
        $table = 'kontaks';
        if (!Schema::hasTable($table)) return;
        // urutan handled generic
        $this->line('[kontaks] cek urutan: handled generic');
    }

    protected function fixGaleriVideo(): void
    {
        foreach (['media_galeris', 'galeris'] as $table) {
            if (!Schema::hasTable($table)) continue;
            // urutan handled generic
            $this->line("[$table] cek urutan: handled generic");
        }

        $table = 'media_videos';
        if (Schema::hasTable($table)) {
            // urutan handled generic

            // Normalisasi youtube_id dari embed_url (opsional)
            if (Schema::hasColumn($table, 'youtube_id') && Schema::hasColumn($table, 'embed_url')) {
                $rows = DB::table($table)
                    ->whereNull('youtube_id')
                    ->whereNotNull('embed_url')
                    ->select('id', 'embed_url')
                    ->limit(1000)
                    ->get();

                if ($rows->count() > 0) {
                    $this->warn("[media_videos] Normalisasi youtube_id dari embed_url: {$rows->count()} kandidat");
                    if (!$this->dry) {
                        foreach ($rows as $r) {
                            $id = $this->extractYoutubeId((string) $r->embed_url);
                            if ($id) {
                                DB::table($table)->where('id', $r->id)->update(['youtube_id' => $id]);
                            }
                        }
                    }
                } else {
                    $this->line('[media_videos] youtube_id/ embed_url: OK atau tidak perlu normalisasi');
                }
            }
        }
    }

    protected function fixKeunggulanPrestasi(): void
    {
        foreach (['keunggulans', 'prestasi_abouts'] as $table) {
            if (!Schema::hasTable($table)) continue;

            // deskripsi: isi placeholder bila null/empty (aman)
            if (Schema::hasColumn($table, 'deskripsi')) {
                $cnt = DB::table($table)->whereNull('deskripsi')->orWhere('deskripsi', '')->count();
                if ($cnt > 0) {
                    $this->warn("[$table] Mengisi deskripsi kosong: {$cnt}");
                    if (!$this->dry) {
                        DB::table($table)
                            ->whereNull('deskripsi')
                            ->orWhere('deskripsi', '')
                            ->update(['deskripsi' => '-']);
                    }
                } else {
                    $this->line("[$table] deskripsi: OK");
                }
            }
            // urutan handled generic
        }
    }

    /** Extract 11-char YouTube ID from URL or return null. */
    protected function extractYoutubeId(string $value): ?string
    {
        $value = trim($value);
        // If already 11-char ID
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $value)) {
            return $value;
        }

        // Try to extract from full URL
        $patterns = [
            '/v=([a-zA-Z0-9_-]{11})/i',
            '/youtu\.be\/([a-zA-Z0-9_-]{11})/i',
            '/embed\/([a-zA-Z0-9_-]{11})/i',
        ];
        foreach ($patterns as $p) {
            if (preg_match($p, $value, $m)) {
                return $m[1];
            }
        }
        return null;
    }
}
