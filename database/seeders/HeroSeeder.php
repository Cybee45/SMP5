<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hero;

class HeroSeeder extends Seeder
{
    public function run(): void
    {
        Hero::updateOrCreate(
            ['tipe' => 'home'],
            [
                'judul' => 'Belajar, berprestasi, dan raih ilmu untuk masa depan',
                'subjudul' => 'Sekolah Menengah Unggulan di Sangatta Utara',
                'deskripsi' => 'Kita ciptakan lingkungan belajar yang patut diacungi jempol. Siswa semangat mendalami ilmu—gerbang sekolah adalah awal perjalananmu.',
                'tombol_teks' => 'Daftar PPDB',
                'tombol_link' => '#',
                'gambar' => null,
                'aktif' => true,
            ]
        );
    }
}
