<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\VisiMisi;

echo "=== VISI MISI DEBUG ===\n";

$count = VisiMisi::count();
echo "Total VisiMisi records: $count\n";

$active = VisiMisi::where('aktif', true)->count();
echo "Active VisiMisi records: $active\n";

$first = VisiMisi::first();
if ($first) {
    echo "First record judul_section: " . $first->judul_section . "\n";
    echo "First record aktif: " . ($first->aktif ? 'true' : 'false') . "\n";
    echo "First record visi: " . substr($first->visi, 0, 50) . "...\n";
} else {
    echo "No VisiMisi records found\n";
}

echo "\n=== COMPONENT TEST ===\n";
$visiMisi = VisiMisi::where('aktif', true)->first();
if ($visiMisi) {
    echo "Component will get data: " . $visiMisi->judul_section . "\n";
} else {
    echo "Component will use default data\n";
}
