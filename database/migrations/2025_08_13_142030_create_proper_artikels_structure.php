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
        Schema::table('artikels', function (Blueprint $table) {
            $table->string('judul')->after('uuid_id');
            $table->string('slug')->unique()->after('judul');
            $table->longText('konten')->after('slug');
            $table->string('gambar')->nullable()->after('konten');
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->after('gambar');
            $table->foreignId('user_id')->nullable()->constrained('users')->after('kategori_id');
            $table->datetime('tanggal_publikasi')->nullable()->after('user_id');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->after('tanggal_publikasi');
            $table->boolean('aktif')->default(true)->after('status');
            $table->text('meta_description')->nullable()->after('aktif');
            $table->text('meta_keywords')->nullable()->after('meta_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('artikels', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'judul', 'slug', 'konten', 'gambar', 'kategori_id', 
                'user_id', 'tanggal_publikasi', 'status', 'aktif',
                'meta_description', 'meta_keywords'
            ]);
        });
    }
};
