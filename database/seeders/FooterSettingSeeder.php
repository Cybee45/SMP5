<?php

namespace Database\Seeders;

use App\Models\FooterSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FooterSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama
        FooterSetting::truncate();

        // Buat footer setting baru dengan menu items
        FooterSetting::create([
            'uuid_id' => Str::uuid(),
            'nama_sekolah' => 'SMP Negeri 5 Sangatta Utara',
            'deskripsi_sekolah' => 'Menjadi Sekolah Unggulan yang Berkualitas dan Berwawasan Lingkungan untuk Membentuk Generasi Pemimpin Berkarakter.',
            'logo_sekolah' => null, // Akan diisi nanti dari FileUpload
            'alamat' => 'Jl. Pendidikan No. 123, Sangatta Utara, Kutai Timur, Kalimantan Timur 75387',
            'telepon_1' => '+62 549 21234',
            'telepon_2' => '+62 549 21235',
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
                    'route_name' => 'blog.index',
                    'icon' => 'heroicon-o-document-text',
                    'aktif' => true,
                    'urutan' => 5
                ],
                [
                    'nama_menu' => 'KONTAK',
                    'url' => '/kontak',
                    'route_name' => 'kontak',
                    'icon' => 'heroicon-o-envelope',
                    'aktif' => true,
                    'urutan' => 6
                ]
            ],
            'aktif' => true,
            'urutan' => 1,
        ]);
    }
}
