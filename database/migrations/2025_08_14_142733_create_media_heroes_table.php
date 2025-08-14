<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('media_heroes', function (Blueprint $table) {
            $table->id();
            $table->string('uuid_id')->unique();
            $table->string('judul_utama');
            $table->string('subjudul')->nullable();
            $table->text('deskripsi');
            $table->string('gambar_hero')->nullable();
            $table->string('gambar_globe')->nullable();
            $table->string('gambar_wave')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_heroes');
    }
};
