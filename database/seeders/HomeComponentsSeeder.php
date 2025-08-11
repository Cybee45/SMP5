<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SectionKeunggulan;
use App\Models\Keunggulan;
use App\Models\Profil;

class HomeComponentsSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Section Keunggulan (Header)
        SectionKeunggulan::create([
            'judul_section' => 'Mengapa Memilih SMP 5 Sangatta Utara?',
            'deskripsi_section' => 'Kami berkomitmen untuk menyediakan lingkungan belajar dengan kualitas yang unggul dan fasilitas terdepan untuk mengembangkan potensi siswa.',
            'aktif' => true,
        ]);

        // Seed Individual Keunggulan Items
        $keunggulans = [
            [
                'judul' => 'Akreditasi B',
                'deskripsi' => 'Terakreditasi B oleh BAN-S/M dengan standar pendidikan yang telah diakui secara nasional.',
                'ikon' => 'heroicon-o-academic-cap',
                'warna' => 'bg-blue-500 text-white',
                'urutan' => 1,
                'aktif' => true,
            ],
            [
                'judul' => 'Guru Bersertifikat',
                'deskripsi' => 'Tenaga pendidik profesional yang bersertifikat dan berpengalaman dalam bidangnya.',
                'ikon' => 'heroicon-o-user-group',
                'warna' => 'bg-green-500 text-white',
                'urutan' => 2,
                'aktif' => true,
            ],
            [
                'judul' => 'Fasilitas Lengkap',
                'deskripsi' => 'Dilengkapi dengan laboratorium, perpustakaan, dan ruang kelas multimedia yang modern.',
                'ikon' => 'heroicon-o-building-office',
                'warna' => 'bg-purple-500 text-white',
                'urutan' => 3,
                'aktif' => true,
            ],
            [
                'judul' => 'Prestasi Gemilang',
                'deskripsi' => 'Meraih berbagai prestasi di tingkat regional dan nasional dalam bidang akademik dan non-akademik.',
                'ikon' => 'heroicon-o-trophy',
                'warna' => 'bg-yellow-500 text-white',
                'urutan' => 4,
                'aktif' => true,
            ],
        ];

        foreach ($keunggulans as $keunggulan) {
            Keunggulan::create($keunggulan);
        }

        // Seed Profil Sekolah
        Profil::create([
            'judul' => 'Profil Singkat Sekolah',
            'deskripsi_1' => 'SMP 5 Sangatta Utara adalah sekolah menengah unggulan yang berdedikasi untuk menciptakan lingkungan belajar yang inklusif, didukung oleh kurikulum inovatif dan fasilitas modern.',
            'deskripsi_2' => 'Kami berkomitmen penuh untuk mencetak generasi berprestasi yang tidak hanya unggul secara akademis, tetapi juga siap dan tangguh dalam menghadapi tantangan masa depan.',
            'gambar' => 'assets/home/smp_5-32.jpg',
            'link_selengkapnya' => '#tentang-kami',
            'aktif' => true,
        ]);
    }
}
