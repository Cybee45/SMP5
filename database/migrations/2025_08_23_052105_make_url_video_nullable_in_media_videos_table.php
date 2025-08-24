<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('media_videos', function (Blueprint $table) {
            // jadikan url_video nullable
            // catatan: kalau DB-mu MySQL lama tanpa doctrine/dbal, ganti ke raw SQL:
            // DB::statement('ALTER TABLE media_videos MODIFY url_video VARCHAR(255) NULL');
            if (Schema::hasColumn('media_videos', 'url_video')) {
                $table->string('url_video', 255)->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('media_videos', function (Blueprint $table) {
            if (Schema::hasColumn('media_videos', 'url_video')) {
                $table->string('url_video', 255)->nullable(false)->change();
            }
        });
    }
};
