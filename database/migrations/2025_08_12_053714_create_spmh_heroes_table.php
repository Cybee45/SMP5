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
        Schema::create('spmh_heroes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('subtitle')->nullable();
            $table->text('title');
            $table->text('description');
            $table->string('image_ornamen')->nullable();
            $table->string('image_back_to_school')->nullable();
            $table->string('image_karakter')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spmh_heroes');
    }
};
