<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        // Kumpulkan kategori unik dari kolom string lama
        $labels = DB::table('media_galeris')
            ->select('kategori')
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->pluck('kategori');

        foreach ($labels as $label) {
            $nama = trim($label);
            $slug = Str::slug(Str::lower($nama));

            // Pastikan satu slug = satu baris
            $catId = DB::table('media_kategoris')->where('slug', $slug)->value('id');
            if (!$catId) {
                $catId = DB::table('media_kategoris')->insertGetId([
                    'nama'       => $nama,
                    'slug'       => $slug,
                    'color'      => null,
                    'urutan'     => 0,
                    'aktif'      => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Isi FK berdasarkan label lama
            DB::table('media_galeris')
                ->where('kategori', $label)
                ->update(['media_kategori_id' => $catId]);
        }
    }

    public function down(): void
    {
        // No-op: biarkan data master tetap ada saat rollback
    }
};
