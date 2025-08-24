<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spmh_contents', function (Blueprint $table) {
            // taruh setelah file_pdf biar rapi
            if (! Schema::hasColumn('spmh_contents', 'nama_file')) {
                $table->string('nama_file')->nullable()->after('file_pdf');
            }
        });
    }

    public function down(): void
    {
        Schema::table('spmh_contents', function (Blueprint $table) {
            if (Schema::hasColumn('spmh_contents', 'nama_file')) {
                $table->dropColumn('nama_file');
            }
        });
    }
};
