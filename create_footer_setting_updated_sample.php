<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\FooterSetting;
use Illuminate\Support\Str;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    // Hapus data lama jika ada
    FooterSetting::truncate();
    
    // Buat footer setting baru dengan menu items
    $footerSetting = FooterSetting::create([
        'uuid_id' => Str::uuid(),
        'nama_sekolah' => 'SMP Negeri 5 Sangatta Utara',
        'deskripsi_sekolah' => 'Menjadi Sekolah Unggulan yang Berkualitas dan Berwawasan Lingkungan untuk Membentuk Generasi Pemimpin Berkarakter.',
        'logo_sekolah' => null, // akan diupload via CMS
        'telepon_1' => '(0549) 21234',
        'telepon_2' => '(0549) 21235',
        'alamat' => 'Jl. Pendidikan No. 1, Sangatta Utara, Kutai Timur, Kalimantan Timur',
        'instagram_url' => 'https://instagram.com/smpn5sangattautara',
        'whatsapp_url' => 'https://wa.me/6254921234',
        'facebook_url' => 'https://facebook.com/smpn5sangattautara',
        'youtube_url' => 'https://youtube.com/@smpn5sangattautara',
        'copyright_text' => '© 2024 SMP Negeri 5 Sangatta Utara. All Rights Reserved.',
        'menu_items' => [
            [
                'nama_menu' => 'HOME',
                'url' => '/',
                'route_name' => 'home',
                'icon' => 'heroicon-o-home',
                'aktif' => true,
                'urutan' => 1
            ],
            [
                'nama_menu' => 'ABOUT US',
                'url' => '/about',
                'route_name' => 'about',
                'icon' => 'heroicon-o-information-circle',
                'aktif' => true,
                'urutan' => 2
            ],
            [
                'nama_menu' => 'SPMB',
                'url' => '/spmb',
                'route_name' => 'spmb',
                'icon' => 'heroicon-o-academic-cap',
                'aktif' => true,
                'urutan' => 3
            ],
            [
                'nama_menu' => 'MEDIA',
                'url' => '/media',
                'route_name' => 'media',
                'icon' => 'heroicon-o-photo',
                'aktif' => true,
                'urutan' => 4
            ],
            [
                'nama_menu' => 'BLOG',
                'url' => '/blog',
                'route_name' => 'blog',
                'icon' => 'heroicon-o-document-text',
                'aktif' => true,
                'urutan' => 5
            ],
            [
                'nama_menu' => 'KONTAK',
                'url' => '/contact',
                'route_name' => 'contact',
                'icon' => 'heroicon-o-envelope',
                'aktif' => true,
                'urutan' => 6
            ]
        ],
        'aktif' => true,
        'urutan' => 1
    ]);

    echo "✅ Footer Setting berhasil dibuat dengan ID: {$footerSetting->id}\n";
    echo "✅ Menu Items berhasil ditambahkan\n";
    echo "✅ Data siap digunakan di CMS!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
