<?php

// database/migrations/2025_08_24_000001_add_image_utama_to_spmh_heroes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('spmh_heroes', function (Blueprint $table) {
            if (! Schema::hasColumn('spmh_heroes', 'image_utama')) {
                $table->string('image_utama')->nullable()->after('description');
            }
        });

        // Backfill dari kolom lama bila ada
        if (Schema::hasColumn('spmh_heroes', 'gambar_utama')) {
            DB::statement('UPDATE spmh_heroes SET image_utama = gambar_utama WHERE image_utama IS NULL AND gambar_utama IS NOT NULL');
        } elseif (Schema::hasColumn('spmh_heroes', 'image')) {
            DB::statement('UPDATE spmh_heroes SET image_utama = image WHERE image_utama IS NULL AND image IS NOT NULL');
        }
    }

    public function down(): void
    {
        Schema::table('spmh_heroes', function (Blueprint $table) {
            if (Schema::hasColumn('spmh_heroes', 'image_utama')) {
                $table->dropColumn('image_utama');
            }
        });
    }
};

