<?php
/**
 * Simple script to check SPMB content data
 */

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CHECKING SPMB CONTENT DATA ===\n\n";

try {
    $contents = App\Models\SpmhContent::all();
    echo "Total SPMB Content records: " . $contents->count() . "\n\n";
    
    foreach ($contents as $content) {
        echo "ID: " . $content->id . "\n";
        echo "Jenis: " . $content->jenis . "\n";
        echo "Judul: " . $content->judul . "\n";
        echo "File PDF: " . ($content->file_pdf ?? 'Not set') . "\n";
        echo "Nama File: " . ($content->nama_file ?? 'Not set') . "\n";
        echo "---\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== COMPLETED ===\n";
