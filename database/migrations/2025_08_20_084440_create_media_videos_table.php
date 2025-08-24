<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ⛑️ Guard: jangan bikin ulang kalau tabel sudah ada
        if (! Schema::hasTable('media_videos')) {
            Schema::create('media_videos', function (Blueprint $table) {
                $table->id();
                $table->string('uuid_id', 36);
                $table->string('judul');
                $table->text('deskripsi')->nullable();
                $table->string('youtube_url');
                $table->string('youtube_id')->nullable();
                $table->string('thumbnail')->nullable();
                $table->integer('urutan')->default(0);
                $table->boolean('aktif')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('media_videos');
    }
};
