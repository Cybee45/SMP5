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
        Schema::table('kontaks', function (Blueprint $table) {
            // Cek dan tambahkan kolom yang mungkin belum ada
            if (!Schema::hasColumn('kontaks', 'urutan')) {
                $table->integer('urutan')->default(0);
            }
            if (!Schema::hasColumn('kontaks', 'aktif')) {
                $table->boolean('aktif')->default(true);
            }
            if (!Schema::hasColumn('kontaks', 'uuid_id')) {
                $table->string('uuid_id', 36)->unique()->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kontaks', function (Blueprint $table) {
            $table->dropColumn(['urutan', 'aktif', 'uuid_id']);
        });
    }
};
