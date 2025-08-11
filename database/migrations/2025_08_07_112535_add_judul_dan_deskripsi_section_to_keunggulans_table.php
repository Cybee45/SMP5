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
    Schema::table('keunggulans', function (Blueprint $table) {
        $table->string('judul_section')->nullable()->after('id');
        $table->text('deskripsi_section')->nullable()->after('judul_section');
    });
}

public function down(): void
{
    Schema::table('keunggulans', function (Blueprint $table) {
        $table->dropColumn(['judul_section', 'deskripsi_section']);
    });
}

};
