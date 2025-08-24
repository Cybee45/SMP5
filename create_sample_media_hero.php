<?php
/**
 * Script untuk menambahkan data contoh MediaHero
 */

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== CREATING SAMPLE MEDIA HERO DATA ===\n\n";

// Check if MediaHero already has data
$existing = App\Models\MediaHero::count();
echo "Existing MediaHero records: {$existing}\n";

if ($existing == 0) {
    echo "Creating sample MediaHero data...\n";
    
    $mediaHero = App\Models\MediaHero::create([
        'subjudul' => 'Galeri & Media Sekolah',
        'judul_utama' => 'Dokumentasi Kegiatan dan Prestasi Siswa',
        'deskripsi' => 'Lihat berbagai kegiatan, prestasi, dan momen berharga yang terekam dalam galeri foto dan video sekolah kami.',
        'aktif' => true
    ]);
    
    echo "✓ Created MediaHero: {$mediaHero->judul_utama}\n";
} else {
    echo "MediaHero data already exists, skipping...\n";
}

echo "\n=== SAMPLE DATA CREATION COMPLETED ===\n";
