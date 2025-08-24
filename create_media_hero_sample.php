<?php
/**
 * Script untuk menambahkan data contoh MediaHero dan memastikan permission cms_media ada
 */

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== MENAMBAHKAN DATA MEDIA HERO & PERMISSION ===\n\n";

// 1. Pastikan permission cms_media ada
echo "1. Checking cms_media permission...\n";
$permission = \Spatie\Permission\Models\Permission::firstOrCreate([
    'name' => 'cms_media',
    'guard_name' => 'web'
]);
echo "   ✅ Permission cms_media: " . ($permission->wasRecentlyCreated ? 'Created' : 'Already exists') . "\n";

// 2. Assign permission ke role admin dan super-admin
echo "\n2. Assigning permission to roles...\n";
$adminRole = \Spatie\Permission\Models\Role::where('name', 'admin')->first();
$superAdminRole = \Spatie\Permission\Models\Role::where('name', 'super-admin')->first();

if ($adminRole) {
    $adminRole->givePermissionTo('cms_media');
    echo "   ✅ Permission assigned to admin role\n";
}

if ($superAdminRole) {
    $superAdminRole->givePermissionTo('cms_media');
    echo "   ✅ Permission assigned to super-admin role\n";
}

// 3. Cek apakah sudah ada data MediaHero
echo "\n3. Checking existing MediaHero data...\n";
$existingCount = \App\Models\MediaHero::count();
echo "   Current MediaHero records: $existingCount\n";

if ($existingCount == 0) {
    echo "\n4. Creating sample MediaHero data...\n";
    
    $mediaHero = \App\Models\MediaHero::create([
        'judul_utama' => 'Kami hadirkan aktivitas dan momen kampus dalam foto, video, dan tulisan.',
        'subjudul' => 'Sekolah Menengah Unggulan di Sangatta Utara',
        'deskripsi' => 'Kita ciptakan lingkungan belajar yang patut diacungi jempol. Siswa bersemangat mendalami ilmu. Gerbang sekolah adalah awal perjalananmu menuju masa depan yang gemilang.',
        'aktif' => true
    ]);
    
    echo "   ✅ Sample MediaHero created with ID: " . $mediaHero->id . "\n";
    echo "   📝 Title: " . $mediaHero->judul_utama . "\n";
    echo "   📝 Subtitle: " . $mediaHero->subjudul . "\n";
} else {
    echo "   ✅ MediaHero data already exists, no need to create sample\n";
}

// 4. Test access to MediaHero
echo "\n5. Testing MediaHero access...\n";
try {
    $activeHero = \App\Models\MediaHero::active()->first();
    if ($activeHero) {
        echo "   ✅ Active MediaHero found: " . $activeHero->judul_utama . "\n";
    } else {
        echo "   ⚠️  No active MediaHero found\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error accessing MediaHero: " . $e->getMessage() . "\n";
}

echo "\n=== SELESAI ===\n";
echo "Silakan refresh halaman admin Filament untuk melihat menu Hero Section di CMS Media.\n";
