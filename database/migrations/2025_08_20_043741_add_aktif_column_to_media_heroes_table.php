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
        Schema::table('media_heroes', function (Blueprint $table) {
            // Kolom active sudah ada, tapi model menggunakan 'aktif'
            // Kita akan menambah kolom aktif yang baru
            $table->boolean('aktif')->default(true)->after('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media_heroes', function (Blueprint $table) {
            $table->dropColumn('aktif');
        });
    }
};
