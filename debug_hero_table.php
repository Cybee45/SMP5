<?php
/**
 * Debug script for Hero model table issue
 */

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DEBUGGING HERO MODEL TABLE ISSUE ===\n\n";

// Test Hero model
echo "1. Testing Hero model...\n";
$hero = new App\Models\Hero();
echo "   Hero model table: " . $hero->getTable() . "\n";

// Test database connection
echo "\n2. Testing database connection...\n";
try {
    $connection = DB::connection();
    echo "   Connection name: " . $connection->getName() . "\n";
    echo "   Database name: " . $connection->getDatabaseName() . "\n";
} catch (Exception $e) {
    echo "   Database connection error: " . $e->getMessage() . "\n";
}

// Test if heroes table exists
echo "\n3. Testing if heroes table exists...\n";
try {
    $tables = DB::select('SHOW TABLES');
    $tableNames = array_map(function($table) {
        return array_values((array)$table)[0];
    }, $tables);
    
    echo "   All tables: " . implode(', ', $tableNames) . "\n";
    echo "   Heroes table exists: " . (in_array('heroes', $tableNames) ? 'YES' : 'NO') . "\n";
    echo "   SPMH Heroes table exists: " . (in_array('spmh_heroes', $tableNames) ? 'YES' : 'NO') . "\n";
} catch (Exception $e) {
    echo "   Error checking tables: " . $e->getMessage() . "\n";
}

// Test direct query on heroes table
echo "\n4. Testing direct query on heroes table...\n";
try {
    $count = DB::table('heroes')->count();
    echo "   Records in heroes table: " . $count . "\n";
} catch (Exception $e) {
    echo "   Error querying heroes table: " . $e->getMessage() . "\n";
}

// Test Hero model query
echo "\n5. Testing Hero model query...\n";
try {
    $heroes = App\Models\Hero::all();
    echo "   Records via Hero model: " . $heroes->count() . "\n";
} catch (Exception $e) {
    echo "   Error with Hero model: " . $e->getMessage() . "\n";
}

echo "\n=== DEBUG COMPLETED ===\n";
