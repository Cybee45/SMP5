<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hero;
use App\Models\Statistik;
use App\Models\Keunggulan;
use App\Models\Profil;

class CmsUuidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Heroes with UUID (struktur sudah ada dan lengkap)
        Hero::create([
            'tipe' => 'home',
            'judul' => 'Selamat Datang di SMP Negeri 5',
            'subjudul' => 'Pendidikan Berkualitas untuk Masa Depan Gemilang',
            'deskripsi' => 'Kami berkomitmen memberikan pendidikan terbaik dengan fasilitas modern dan tenaga pengajar profesional.',
            'tombol_teks' => 'Pelajari Lebih Lanjut',
            'tombol_link' => '/profil',
            'aktif' => true
        ]);

        // Seed Statistik with UUID (struktur sudah ada dan lengkap)
        Statistik::create([
            'judul' => 'Siswa Aktif',
            'jumlah' => 960,
            'deskripsi' => 'Total siswa yang aktif belajar di sekolah',
            'ikon' => 'user-group',
            'warna_icon' => 'text-blue-600',
            'urutan' => 1,
            'aktif' => true
        ]);

        Statistik::create([
            'judul' => 'Guru Profesional',
            'jumlah' => 45,
            'deskripsi' => 'Tenaga pengajar berpengalaman dan berkualitas',
            'ikon' => 'academic-cap',
            'warna_icon' => 'text-green-600',
            'urutan' => 2,
            'aktif' => true
        ]);

        // Seed Keunggulan with UUID (struktur sudah ada dan lengkap)
        Keunggulan::create([
            'judul' => 'Fasilitas Modern',
            'deskripsi' => 'Dilengkapi dengan laboratorium komputer, laboratorium IPA, dan perpustakaan digital',
            'ikon' => 'computer-desktop',
            'warna' => 'bg-blue-500',
            'urutan' => 1,
            'aktif' => true
        ]);

        Keunggulan::create([
            'judul' => 'Tenaga Pengajar Berkualitas',
            'deskripsi' => 'Guru-guru berpengalaman dengan kualifikasi S1 dan S2 yang siap membimbing siswa',
            'ikon' => 'user-group',
            'warna' => 'bg-green-500',
            'urutan' => 2,
            'aktif' => true
        ]);

        // Seed Profil with UUID (struktur sudah ada dan lengkap)
        Profil::create([
            'judul' => 'Tentang SMP Negeri 5',
            'deskripsi_1' => 'SMP Negeri 5 adalah institusi pendidikan yang berkomitmen untuk memberikan pendidikan berkualitas tinggi dengan mengintegrasikan nilai-nilai akademik dan karakter.',
            'deskripsi_2' => 'Dengan fasilitas modern dan tenaga pengajar profesional, kami mempersiapkan siswa untuk menghadapi tantangan masa depan dengan percaya diri.',
            'link_selengkapnya' => '/profil-lengkap',
            'aktif' => true
        ]);
    }
}
