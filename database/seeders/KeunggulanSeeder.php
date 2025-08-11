<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Keunggulan;

class KeunggulanSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel keunggulan.
     */
    public function run(): void
{
    Keunggulan::truncate();

    Keunggulan::insert([
        [
            'judul_section' => 'Mengapa Memilih SMP 5 Sangatta Utara?',
            'deskripsi_section' => 'Kami berkomitmen untuk menyediakan lingkungan belajar yang inspiratif dengan standar kualitas yang terjamin di setiap aspek.',
            'judul' => 'Akreditasi "B"',
            'deskripsi' => 'Sekolah telah terakreditasi B, memastikan mutu pendidikan yang terjamin dan diakui secara resmi.',
            'ikon' => 'check-circle',
            'warna' => 'bg-sky-100 text-sky-600',
            'urutan' => 1,
            'aktif' => true,
        ],
        [
            'judul_section' => null,
            'deskripsi_section' => null,
            'judul' => 'Akreditasi "B"',
            'deskripsi' => 'Sekolah telah terakreditasi B, memastikan mutu pendidikan yang terjamin dan diakui secara resmi.',
            'ikon' => 'check-circle',
            'warna' => 'bg-sky-100 text-sky-600',
            'urutan' => 1,
            'aktif' => true,
        ],
        [
            'judul_section' => null,
            'deskripsi_section' => null,
            'judul' => 'Guru Bersertifikat',
            'deskripsi' => 'Didukung oleh 55 tenaga pendidik profesional yang telah bersertifikat secara nasional.',
            'ikon' => 'academic-cap',
            'warna' => 'bg-indigo-100 text-indigo-600',
            'urutan' => 2,
            'aktif' => true,
        ],
        [
            'judul_section' => null,
            'deskripsi_section' => null,
            'judul' => 'Fasilitas Lengkap',
            'deskripsi' => 'Mulai dari laboratorium, perpustakaan, aula, hingga fasilitas olahraga yang modern dan terawat.',
            'ikon' => 'building-library',
            'warna' => 'bg-emerald-100 text-emerald-600',
            'urutan' => 3,
            'aktif' => true,
        ],
        [
            'judul_section' => null,
            'deskripsi_section' => null,
            'judul' => 'Ekskul Beragam',
            'deskripsi' => 'Berbagai pilihan ekskul di bidang seni, olahraga, dan sains untuk mengembangkan seluruh bakat siswa.',
            'ikon' => 'sparkles',
            'warna' => 'bg-rose-100 text-rose-600',
            'urutan' => 4,
            'aktif' => true,
        ],
    ]);
}
}