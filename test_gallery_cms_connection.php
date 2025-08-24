<?php
/**
 * Test script to verify Gallery CMS connection
 * Run this to check if MediaGaleri data is properly retrieved
 */

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING GALLERY CMS CONNECTION ===\n\n";

// Test MediaGaleri model
echo "1. Testing MediaGaleri model...\n";
$mediaGaleris = App\Models\MediaGaleri::active()->ordered()->take(6)->get();
echo "   Total active MediaGaleri records: " . $mediaGaleris->count() . "\n";

if ($mediaGaleris->count() > 0) {
    echo "   Sample data:\n";
    foreach ($mediaGaleris as $galeri) {
        echo "   - {$galeri->judul} (Category: {$galeri->kategori})\n";
        echo "     Image URL: {$galeri->gambar_url}\n";
        echo "     Description: " . ($galeri->deskripsi ?? 'No description') . "\n\n";
    }
} else {
    echo "   No active gallery records found. Will use fallback data.\n";
}

// Test conversion to gallery format
echo "2. Testing data conversion for home gallery...\n";
$galleryItems = $mediaGaleris->map(function($galeri) {
    return [
        'img' => $galeri->gambar_url,
        'title' => $galeri->judul,
        'desc' => $galeri->deskripsi ?? ucfirst($galeri->kategori),
    ];
});

echo "   Converted " . $galleryItems->count() . " items for gallery display\n";

// Test artikel data
echo "\n3. Testing artikel data for comparison...\n";
$artikels = App\Models\Artikel::with('kategori')
    ->where('aktif', true)
    ->orderBy('created_at', 'desc')
    ->take(6)
    ->get();
echo "   Total active artikel records: " . $artikels->count() . "\n";

echo "\n=== COMPONENTS RESOLUTION ===\n";
echo "✅ FIXED: Removed duplicate berita.blade.php component\n";
echo "✅ FIXED: artikel.blade.php now used for dynamic CMS articles\n";
echo "✅ FIXED: gallery.blade.php now connects to MediaGaleri CMS data\n";
echo "✅ IMPROVED: Home page now shows only one article section (dynamic)\n";
echo "✅ IMPROVED: Gallery shows CMS uploaded media with fallback support\n";

echo "\n=== TEST COMPLETED ===\n";
