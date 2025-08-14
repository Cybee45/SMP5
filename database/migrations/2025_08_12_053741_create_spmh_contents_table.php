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
        Schema::create('spmh_contents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('jenis', ['persyaratan', 'tata_cara', 'jadwal', 'kontak', 'alur']);
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('icon')->nullable();
            $table->json('konten')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
            
            $table->index(['jenis', 'aktif', 'urutan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spmh_contents');
    }
};
