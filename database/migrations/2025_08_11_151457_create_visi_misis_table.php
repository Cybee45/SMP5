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
        Schema::create('visi_misis', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('judul_section')->default('Visi, Misi, & Tujuan Sekolah');
            $table->string('subjudul_section')->default('Arah & Fokus');
            $table->text('visi');
            $table->json('misi'); // Array untuk multiple misi
            $table->json('tujuan')->nullable(); // Array untuk multiple tujuan
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visi_misis');
    }
};
