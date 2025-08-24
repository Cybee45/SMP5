<?php
/**
 * Fix Artikel user_id issue
 * This script will check and fix the artikels table structure
 */

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

// Setup Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ARTIKEL USER_ID FIX ===\n\n";

try {
    // Check if artikels table exists
    if (Schema::hasTable('artikels')) {
        echo "✓ Tabel artikels ditemukan\n";
        
        // Get table columns
        $columns = Schema::getColumnListing('artikels');
        echo "Kolom-kolom tabel artikels:\n";
        foreach ($columns as $column) {
            echo "  - $column\n";
        }
        
        // Check if user_id column exists and its properties
        if (in_array('user_id', $columns)) {
            echo "\n✓ Kolom user_id sudah ada\n";
            
            // Get column details
            $columnType = DB::select("DESCRIBE artikels user_id")[0];
            echo "Detail kolom user_id:\n";
            echo "  - Type: {$columnType->Type}\n";
            echo "  - Null: {$columnType->Null}\n";
            echo "  - Key: {$columnType->Key}\n";
            echo "  - Default: {$columnType->Default}\n";
            echo "  - Extra: {$columnType->Extra}\n";
            
            // If user_id doesn't allow NULL and has no default, we need to fix it
            if ($columnType->Null === 'NO' && $columnType->Default === null) {
                echo "\n⚠️  Problem detected: user_id NOT NULL tanpa default value\n";
                echo "Fixing user_id column to allow NULL...\n";
                
                Schema::table('artikels', function (Blueprint $table) {
                    $table->unsignedBigInteger('user_id')->nullable()->change();
                });
                
                echo "✓ user_id column updated to allow NULL\n";
            } else {
                echo "\n✓ user_id column configuration is OK\n";
            }
        } else {
            echo "\n❌ Kolom user_id tidak ditemukan, membuat kolom...\n";
            
            Schema::table('artikels', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            });
            
            echo "✓ user_id column created with foreign key\n";
        }
        
        // Check current artikel records without user_id
        $artikelsWithoutUser = DB::table('artikels')->whereNull('user_id')->count();
        if ($artikelsWithoutUser > 0) {
            echo "\n⚠️  Found $artikelsWithoutUser artikel(s) without user_id\n";
            echo "Updating existing artikels to use first admin user...\n";
            
            // Get first admin user
            $adminUser = DB::table('users')->where('email', 'like', '%admin%')->first();
            if (!$adminUser) {
                $adminUser = DB::table('users')->first();
            }
            
            if ($adminUser) {
                DB::table('artikels')
                    ->whereNull('user_id')
                    ->update(['user_id' => $adminUser->id]);
                    
                echo "✓ Updated existing artikels to use user ID: {$adminUser->id}\n";
            } else {
                echo "❌ No users found in database\n";
            }
        }
        
    } else {
        echo "❌ Tabel artikels tidak ditemukan\n";
    }
    
    echo "\n=== FIX COMPLETED ===\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
