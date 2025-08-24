<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('media_videos', function (Blueprint $table) {
            // Tambah url YouTube setelah deskripsi
            if (!Schema::hasColumn('media_videos', 'youtube_url')) {
                $table->string('youtube_url', 255)->nullable()->after('deskripsi');
            }

            // Pastikan kolom youtube_id ada (kalau belum)
            if (!Schema::hasColumn('media_videos', 'youtube_id')) {
                $table->string('youtube_id', 32)->nullable()->after('youtube_url');
            }

            // (Opsional) indeks untuk pencarian cepat
            if (!Schema::hasColumn('media_videos', 'youtube_id')) {
                $table->index('youtube_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('media_videos', function (Blueprint $table) {
            if (Schema::hasColumn('media_videos', 'youtube_id')) {
                $table->dropIndex(['youtube_id']);
                $table->dropColumn('youtube_id');
            }
            if (Schema::hasColumn('media_videos', 'youtube_url')) {
                $table->dropColumn('youtube_url');
            }
        });
    }
};
