<?php
/**
 * Debug script untuk SpmhContent
 */

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DEBUGGING SPMH CONTENT ===\n\n";

echo "1. Checking SpmhContent records...\n";
$contents = App\Models\SpmhContent::all();
echo "   Total records: " . $contents->count() . "\n";

if ($contents->count() > 0) {
    echo "   Records:\n";
    foreach ($contents as $content) {
        echo "   - ID: {$content->id} | Judul: {$content->judul} | Jenis: {$content->jenis}\n";
    }
} else {
    echo "   No records found.\n";
}

echo "\n2. Testing specific ID 3...\n";
try {
    $content3 = App\Models\SpmhContent::find(3);
    if ($content3) {
        echo "   Found record with ID 3: {$content3->judul}\n";
    } else {
        echo "   No record found with ID 3\n";
    }
} catch (Exception $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}

echo "\n3. Testing route model binding...\n";
echo "   SpmhContent route key: " . (new App\Models\SpmhContent())->getRouteKeyName() . "\n";

echo "\n4. Testing permissions...\n";
try {
    $user = Auth::user();
    if ($user) {
        echo "   Current user: {$user->name}\n";
        echo "   Can view any spmh content: " . ($user->can('view_any_spmh::content') ? 'YES' : 'NO') . "\n";
        echo "   Can update spmh content: " . ($user->can('update_spmh::content') ? 'YES' : 'NO') . "\n";
        echo "   Has spmb_management permission: " . ($user->can('spmb_management') ? 'YES' : 'NO') . "\n";
    } else {
        echo "   No authenticated user\n";
    }
} catch (Exception $e) {
    echo "   Error checking permissions: " . $e->getMessage() . "\n";
}

echo "\n=== DEBUG COMPLETED ===\n";
