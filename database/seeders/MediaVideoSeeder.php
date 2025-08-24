<?php

namespace Database\Seeders;

use App\Models\MediaVideo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MediaVideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama
        MediaVideo::truncate();

        // Buat sample video
        MediaVideo::create([
            'uuid_id' => Str::uuid(),
            'judul' => 'Selamat Datang di SMP Negeri 5 Sangatta Utara',
            'deskripsi' => 'Tempat di mana setiap langkah adalah proses menuju masa depan. Di sini, kami tidak hanya mengajarkan ilmu, tapi juga membentuk karakter, menggali potensi, dan menanamkan nilai-nilai kehidupan. Kami hadirkan semangat belajar, kerja keras, dan prestasi dalam setiap momen.',
            'youtube_url' => 'https://www.youtube.com/watch?v=yNAFtADhzss',
            'youtube_id' => 'yNAFtADhzss', // akan auto-extract dari URL
            'thumbnail' => null, // menggunakan thumbnail YouTube
            'urutan' => 1,
            'aktif' => true,
        ]);

        // Tambahkan video kedua sebagai contoh
        MediaVideo::create([
            'uuid_id' => Str::uuid(),
            'judul' => 'Kegiatan Ekstrakurikuler SMP 5 Sangatta Utara',
            'deskripsi' => 'Berbagai kegiatan ekstrakurikuler yang mengembangkan bakat dan minat siswa di bidang olahraga, seni, dan akademik.',
            'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // placeholder
            'youtube_id' => 'dQw4w9WgXcQ',
            'thumbnail' => null,
            'urutan' => 2,
            'aktif' => false, // tidak aktif sebagai contoh
        ]);
    }
}
