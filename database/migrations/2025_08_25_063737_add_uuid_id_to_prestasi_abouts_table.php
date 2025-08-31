<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_uuid_id_to_prestasi_abouts_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('prestasi_abouts', function (Blueprint $table) {
            if (!Schema::hasColumn('prestasi_abouts', 'uuid_id')) {
                $table->uuid('uuid_id')->nullable()->unique()->after('id');
            }
        });
    }

    public function down(): void {
        Schema::table('prestasi_abouts', function (Blueprint $table) {
            if (Schema::hasColumn('prestasi_abouts', 'uuid_id')) {
                $table->dropColumn('uuid_id');
            }
        });
    }
};
