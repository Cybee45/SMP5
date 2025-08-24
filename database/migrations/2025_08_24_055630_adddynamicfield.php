<?php

// database/migrations/2025_08_24_000002_add_dynamic_fields_to_spmh_contents_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('spmh_contents', function (Blueprint $table) {
            // konten umum
            if (!Schema::hasColumn('spmh_contents', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('judul');
            }
            if (!Schema::hasColumn('spmh_contents', 'urutan')) {
                $table->unsignedInteger('urutan')->default(0)->after('deskripsi');
            }
            if (!Schema::hasColumn('spmh_contents', 'aktif')) {
                $table->boolean('aktif')->default(true)->after('urutan');
            }

            // cluster Persyaratan
            if (!Schema::hasColumn('spmh_contents', 'deskripsi_pembuka')) {
                $table->text('deskripsi_pembuka')->nullable()->after('aktif');
            }
            if (!Schema::hasColumn('spmh_contents', 'dokumen_wajib')) {
                $table->json('dokumen_wajib')->nullable()->after('deskripsi_pembuka');
            }
            if (!Schema::hasColumn('spmh_contents', 'dokumen_pendukung')) {
                $table->json('dokumen_pendukung')->nullable()->after('dokumen_wajib');
            }
            if (!Schema::hasColumn('spmh_contents', 'ketentuan_berkas')) {
                $table->json('ketentuan_berkas')->nullable()->after('dokumen_pendukung');
            }
            if (!Schema::hasColumn('spmh_contents', 'catatan_penting')) {
                $table->text('catatan_penting')->nullable()->after('ketentuan_berkas');
            }

            // cluster Tata Cara
            if (!Schema::hasColumn('spmh_contents', 'tahap_persiapan')) {
                $table->json('tahap_persiapan')->nullable()->after('catatan_penting');
            }
            if (!Schema::hasColumn('spmh_contents', 'tahap_pendaftaran')) {
                $table->json('tahap_pendaftaran')->nullable()->after('tahap_persiapan');
            }
            if (!Schema::hasColumn('spmh_contents', 'tahap_seleksi')) {
                $table->json('tahap_seleksi')->nullable()->after('tahap_pendaftaran');
            }
            if (!Schema::hasColumn('spmh_contents', 'tahap_pengumuman')) {
                $table->json('tahap_pengumuman')->nullable()->after('tahap_seleksi');
            }
            if (!Schema::hasColumn('spmh_contents', 'jadwal_penting')) {
                $table->json('jadwal_penting')->nullable()->after('tahap_pengumuman');
            }
            if (!Schema::hasColumn('spmh_contents', 'tips_sukses')) {
                $table->json('tips_sukses')->nullable()->after('jadwal_penting');
            }

            // cluster Formulir / file pendukung
            if (!Schema::hasColumn('spmh_contents', 'file_pdf')) {
                $table->string('file_pdf')->nullable()->after('tips_sukses');
            }
            if (!Schema::hasColumn('spmh_contents', 'nama_file')) {
                $table->string('nama_file')->nullable()->after('file_pdf');
            }
        });
    }

    public function down(): void
    {
        Schema::table('spmh_contents', function (Blueprint $table) {
            foreach ([
                'deskripsi','urutan','aktif',
                'deskripsi_pembuka','dokumen_wajib','dokumen_pendukung','ketentuan_berkas','catatan_penting',
                'tahap_persiapan','tahap_pendaftaran','tahap_seleksi','tahap_pengumuman','jadwal_penting','tips_sukses',
                'file_pdf','nama_file',
            ] as $col) {
                if (Schema::hasColumn('spmh_contents', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
