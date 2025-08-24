<?php
/**
 * Debug script untuk SPMB Content
 */

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DEBUG SPMB CONTENT ===\n\n";

// Test SPMB Content records
echo "1. SPMB Content Records:\n";
$records = App\Models\SpmhContent::all();
foreach($records as $record) {
    echo "   ID: {$record->id} | UUID: {$record->uuid_id} | Judul: {$record->judul}\n";
}

// Test specific record ID 3
echo "\n2. Testing Record ID 3:\n";
$record3 = App\Models\SpmhContent::find(3);
if ($record3) {
    echo "   Found record ID 3: {$record3->judul}\n";
    echo "   UUID: {$record3->uuid_id}\n";
} else {
    echo "   Record ID 3 not found\n";
}

// Test SpmhContentResource recordRouteKeyName
echo "\n3. Testing Resource Configuration:\n";
$resource = new App\Filament\Resources\SpmhContentResource();
echo "   Model: " . $resource::getModel() . "\n";

// Test model route key
$model = new App\Models\SpmhContent();
echo "   Model route key name: " . $model->getRouteKeyName() . "\n";

echo "\n=== DEBUG COMPLETED ===\n";
