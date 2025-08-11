<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('statistiks', function (Blueprint $table) {
            $table->string('warna_icon')->nullable()->after('ikon');
        });
    }

    public function down(): void
    {
        Schema::table('statistiks', function (Blueprint $table) {
            $table->dropColumn('warna_icon');
        });
    }
};