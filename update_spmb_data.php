<?php
/**
 * Update SPMB Content data to use correct jenis
 */

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== UPDATING SPMB CONTENT DATA ===\n\n";

try {
    // Update setiap record secara terpisah untuk menghindari masalah data truncation
    echo "Updating records one by one...\n\n";
    
    // Update record 1 - Persyaratan
    $record1 = App\Models\SpmhContent::find(1);
    if ($record1) {
        $record1->jenis = 'persyaratan';
        $record1->aktif = true;
        $record1->save();
        echo "✅ Updated record 1: {$record1->judul} -> jenis: persyaratan\n";
    }
    
    // Update record 2 - Tata Cara (gunakan nilai yang lebih pendek)
    $record2 = App\Models\SpmhContent::find(2);
    if ($record2) {
        $record2->jenis = 'alur'; // gunakan nilai yang sudah ada sebelumnya
        $record2->aktif = true;
        $record2->save();
        echo "✅ Updated record 2: {$record2->judul} -> jenis: alur\n";
    }
    
    // Update record 3 - Formulir (gunakan nilai yang lebih pendek)
    $record3 = App\Models\SpmhContent::find(3);
    if ($record3) {
        $record3->jenis = 'info'; // gunakan nilai yang sudah ada sebelumnya  
        $record3->judul = 'Download Formulir';
        $record3->aktif = true;
        $record3->save();
        echo "✅ Updated record 3: {$record3->judul} -> jenis: info\n";
    }

    echo "\n=== UPDATE COMPLETED ===\n";
    
    // Show current data
    echo "\nCurrent SPMB Content records:\n";
    $contents = App\Models\SpmhContent::all();
    foreach ($contents as $content) {
        echo "- ID: {$content->id} | Jenis: {$content->jenis} | Judul: {$content->judul}\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== SCRIPT COMPLETED ===\n";
