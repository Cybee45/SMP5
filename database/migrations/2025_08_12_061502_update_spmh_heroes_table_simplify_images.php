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
        Schema::table('spmh_heroes', function (Blueprint $table) {
            // Check if columns exist before dropping
            if (Schema::hasColumn('spmh_heroes', 'image_ornamen')) {
                $table->dropColumn('image_ornamen');
            }
            if (Schema::hasColumn('spmh_heroes', 'image_back_to_school')) {
                $table->dropColumn('image_back_to_school');
            }
            if (Schema::hasColumn('spmh_heroes', 'image_karakter')) {
                $table->dropColumn('image_karakter');
            }
            
            // Add new single image column if not exists
            if (!Schema::hasColumn('spmh_heroes', 'image_utama')) {
                $table->string('image_utama')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spmh_heroes', function (Blueprint $table) {
            // Drop new column
            $table->dropColumn('image_utama');
            
            // Restore old columns
            $table->string('image_ornamen')->nullable()->after('description');
            $table->string('image_back_to_school')->nullable()->after('image_ornamen');
            $table->string('image_karakter')->nullable()->after('image_back_to_school');
        });
    }
};
