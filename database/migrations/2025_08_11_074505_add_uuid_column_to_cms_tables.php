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
        // Add UUID column to Heroes table
        if (Schema::hasTable('heroes')) {
            Schema::table('heroes', function (Blueprint $table) {
                $table->uuid('uuid')->nullable()->unique()->after('id');
            });
        }

        // Add UUID column to Statistiks table
        if (Schema::hasTable('statistiks')) {
            Schema::table('statistiks', function (Blueprint $table) {
                $table->uuid('uuid')->nullable()->unique()->after('id');
            });
        }

        // Add UUID column to Galeris table
        if (Schema::hasTable('galeris')) {
            Schema::table('galeris', function (Blueprint $table) {
                $table->uuid('uuid')->nullable()->unique()->after('id');
            });
        }

        // Add UUID column to Kategoris table
        if (Schema::hasTable('kategoris')) {
            Schema::table('kategoris', function (Blueprint $table) {
                $table->uuid('uuid')->nullable()->unique()->after('id');
            });
        }

        // Add UUID column to Keunggulans table
        if (Schema::hasTable('keunggulans')) {
            Schema::table('keunggulans', function (Blueprint $table) {
                $table->uuid('uuid')->nullable()->unique()->after('id');
            });
        }

        // Add UUID column to Profils table
        if (Schema::hasTable('profils')) {
            Schema::table('profils', function (Blueprint $table) {
                $table->uuid('uuid')->nullable()->unique()->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['heroes', 'statistiks', 'galeris', 'kategoris', 'keunggulans', 'profils'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('uuid');
                });
            }
        }
    }
};
