<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('statistiks', function (Blueprint $table) {
            // Tambah kolom hanya kalau belum ada (aman untuk rerun)
            if (! Schema::hasColumn('statistiks', 'deskripsi')) {
                $table->string('deskripsi', 255)->nullable()->after('jumlah');
            }
            if (! Schema::hasColumn('statistiks', 'ikon')) {
                $table->string('ikon', 100)->nullable()->after('deskripsi'); // nama icon, opsional
            }
            if (! Schema::hasColumn('statistiks', 'warna_icon')) {
                $table->string('warna_icon', 50)->nullable()->after('ikon'); // contoh: text-sky-600
            }
            if (! Schema::hasColumn('statistiks', 'urutan')) {
                $table->unsignedInteger('urutan')->default(1)->after('warna_icon');
            }
            if (! Schema::hasColumn('statistiks', 'aktif')) {
                $table->boolean('aktif')->default(true)->after('urutan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('statistiks', function (Blueprint $table) {
            // Drop juga aman kalau ada
            if (Schema::hasColumn('statistiks', 'deskripsi'))   $table->dropColumn('deskripsi');
            if (Schema::hasColumn('statistiks', 'ikon'))        $table->dropColumn('ikon');
            if (Schema::hasColumn('statistiks', 'warna_icon'))  $table->dropColumn('warna_icon');
            if (Schema::hasColumn('statistiks', 'urutan'))      $table->dropColumn('urutan');
            if (Schema::hasColumn('statistiks', 'aktif'))       $table->dropColumn('aktif');
        });
    }
};
