<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Jangan bikin ulang kalau sudah ada
        if (! Schema::hasTable('kontaks')) {
            Schema::create('kontaks', function (Blueprint $table) {
                $table->id();
                $table->char('uuid_id', 36)->unique();

                $table->string('section_title')->default('Hubungi & Kunjungi Kami');
                // Kolom TEXT sebaiknya tanpa default literal panjang (MySQL bisa baper)
                $table->text('section_description')->nullable();

                $table->string('email_title')->default('Email Pertanyaan');
                $table->text('email_description')->nullable();
                $table->string('email_address')->default('info@smpn5sangatta.sch.id');

                $table->string('phone_title')->default('Telepon & WhatsApp');
                $table->text('phone_description')->nullable();
                $table->string('phone_number')->default('+62 832-8907-4832');

                $table->string('location_title')->default('Kunjungi Sekolah Kami');
                $table->text('location_address')->nullable();
                $table->text('map_embed')->nullable();

                $table->integer('urutan')->default(0);
                $table->boolean('aktif')->default(true);

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kontaks');
    }
};
