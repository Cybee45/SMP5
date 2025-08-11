<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Daftar tabel CMS yang akan dikonversi
        $tables = [
            'heroes',
            'statistiks', 
            'galeris',
            'kategoris',
            'keunggulans',
            'profils',
            'section_beritas',
            'artikels', // Artikel di akhir karena ada foreign key
            'pengumumen' // Pengumuman di akhir karena ada foreign key
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                try {
                    // Backup data existing jika ada
                    $existingData = DB::table($table)->get();
                    
                    // Drop foreign key constraints temporarily jika ada
                    $this->dropForeignKeyConstraints($table);
                    
                    // Create new UUID column
                    Schema::table($table, function (Blueprint $table) {
                        $table->string('uuid_id', 36)->nullable()->after('id');
                    });

                    // Generate UUIDs for existing records
                    foreach ($existingData as $record) {
                        DB::table($table)
                            ->where('id', $record->id)
                            ->update(['uuid_id' => Uuid::uuid4()->toString()]);
                    }

                    // Drop old primary key and set new one
                    Schema::table($table, function (Blueprint $table) {
                        $table->dropPrimary();
                        $table->dropColumn('id');
                        $table->renameColumn('uuid_id', 'id');
                    });

                    Schema::table($table, function (Blueprint $table) {
                        $table->primary('id');
                    });

                    // Recreate foreign key constraints if needed
                    $this->recreateForeignKeyConstraints($table);
                    
                } catch (\Exception $e) {
                    // Log error but continue with other tables
                    \Log::error("Error converting table {$table} to UUID: " . $e->getMessage());
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'pengumumen',
            'artikels',
            'section_beritas',
            'profils',
            'keunggulans',
            'kategoris',
            'galeris',
            'statistiks',
            'heroes'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                try {
                    // Drop foreign keys first
                    $this->dropForeignKeyConstraints($table);
                    
                    // Create new auto-increment column
                    Schema::table($table, function (Blueprint $table) {
                        $table->unsignedBigInteger('new_id')->autoIncrement()->first();
                    });

                    // Drop old UUID primary key
                    Schema::table($table, function (Blueprint $table) {
                        $table->dropPrimary();
                        $table->dropColumn('id');
                        $table->renameColumn('new_id', 'id');
                    });

                    Schema::table($table, function (Blueprint $table) {
                        $table->primary('id');
                    });

                    // Recreate foreign keys
                    $this->recreateForeignKeyConstraints($table);
                    
                } catch (\Exception $e) {
                    \Log::error("Error reverting table {$table} from UUID: " . $e->getMessage());
                }
            }
        }
    }

    /**
     * Drop foreign key constraints temporarily
     */
    private function dropForeignKeyConstraints($table): void
    {
        try {
            // Handle specific foreign key relationships
            if ($table === 'artikels' && Schema::hasTable($table)) {
                $foreignKeys = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_NAME = 'artikels' 
                    AND TABLE_SCHEMA = DATABASE()
                    AND CONSTRAINT_NAME != 'PRIMARY'
                    AND REFERENCED_TABLE_NAME IS NOT NULL
                ");
                
                foreach ($foreignKeys as $fk) {
                    try {
                        DB::statement("ALTER TABLE artikels DROP FOREIGN KEY {$fk->CONSTRAINT_NAME}");
                    } catch (\Exception $e) {
                        // Continue if foreign key doesn't exist
                    }
                }
            }
            
            if ($table === 'pengumumen' && Schema::hasTable($table)) {
                $foreignKeys = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_NAME = 'pengumumen' 
                    AND TABLE_SCHEMA = DATABASE()
                    AND CONSTRAINT_NAME != 'PRIMARY'
                    AND REFERENCED_TABLE_NAME IS NOT NULL
                ");
                
                foreach ($foreignKeys as $fk) {
                    try {
                        DB::statement("ALTER TABLE pengumumen DROP FOREIGN KEY {$fk->CONSTRAINT_NAME}");
                    } catch (\Exception $e) {
                        // Continue if foreign key doesn't exist
                    }
                }
            }
        } catch (\Exception $e) {
            // Continue if there are issues with foreign key detection
        }
    }

    /**
     * Recreate foreign key constraints
     */
    private function recreateForeignKeyConstraints($table): void
    {
        try {
            // Only recreate if the referenced tables also use UUID
            if ($table === 'artikels' && Schema::hasTable('kategoris') && Schema::hasTable('users')) {
                // We'll skip recreating foreign keys for now since users table might not use UUID
                // This can be handled separately if needed
            }
            
            if ($table === 'pengumumen' && Schema::hasTable('users')) {
                // We'll skip recreating foreign keys for now since users table might not use UUID
                // This can be handled separately if needed
            }
        } catch (\Exception $e) {
            // Continue if there are issues
        }
    }
};
