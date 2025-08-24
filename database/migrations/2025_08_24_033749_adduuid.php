<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media_kategoris', function (Blueprint $table) {
            if (! Schema::hasColumn('media_kategoris', 'uuid_id')) {
                $table->uuid('uuid_id')->nullable()->unique()->after('id');
            }
        });

        // Backfill untuk baris lama
        $rows = DB::table('media_kategoris')
            ->whereNull('uuid_id')->orWhere('uuid_id', '')
            ->pluck('id');

        foreach ($rows as $id) {
            DB::table('media_kategoris')->where('id', $id)
              ->update(['uuid_id' => (string) Str::uuid()]);
        }

        // (opsional) jadikan NOT NULL setelah terisi semua
        // Schema::table('media_kategoris', function (Blueprint $table) {
        //     $table->uuid('uuid_id')->nullable(false)->change();
        // });
    }

    public function down(): void
    {
        Schema::table('media_kategoris', function (Blueprint $table) {
            if (Schema::hasColumn('media_kategoris', 'uuid_id')) {
                $table->dropUnique(['uuid_id']);
                $table->dropColumn('uuid_id');
            }
        });
    }
};
