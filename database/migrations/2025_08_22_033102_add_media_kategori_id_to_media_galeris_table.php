<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('media_galeris', function (Blueprint $table) {
            $table->foreignId('media_kategori_id')
                ->nullable()
                ->after('kategori')
                ->constrained('media_kategoris')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('media_galeris', function (Blueprint $table) {
            $table->dropConstrainedForeignId('media_kategori_id');
        });
    }
};
