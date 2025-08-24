<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prestasi_abouts', function (Blueprint $table) {
            $table->foreignId('section_akreditasi_id')
                ->nullable()
                ->constrained('section_akreditasis')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('prestasi_abouts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('section_akreditasi_id');
        });
    }
};
