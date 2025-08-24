<?php

namespace Database\Seeders;

use App\Models\SectionAkreditasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SectionAkreditasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama
        SectionAkreditasi::truncate();

        // Buat section akreditasi
        SectionAkreditasi::create([
            'uuid_id' => Str::uuid(),
            'judul_section' => 'Prestasi & Akreditasi',
            'deskripsi_akreditasi' => 'SMP Negeri 5 Sangatta Utara telah meraih berbagai prestasi dan memiliki akreditasi yang menandakan sekolah ini memiliki kualitas pendidikan yang baik, didukung kurikulum sesuai standar, guru kompeten, dan fasilitas memadai. Sekolah terus berkomitmen meningkatkan mutu demi meraih prestasi lebih tinggi.',
            'gambar_akreditasi' => null, // Akan diisi nanti dari FileUpload
            'urutan' => 1,
            'aktif' => true,
        ]);
    }
}
