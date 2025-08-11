<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Statistik;

class StatistikSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'judul' => 'Siswa Aktif',
                'jumlah' => '960',
                'deskripsi' => 'Siswa yang sedang aktif belajar',
                'ikon' => 'user-group',
                'warna_icon' => 'text-sky-600',
                'urutan' => 1,
                'aktif' => true,
            ],
            [
                'judul' => 'Guru Profesional',
                'jumlah' => '55',
                'deskripsi' => 'Tenaga pengajar berdedikasi',
                'ikon' => 'user-circle',
                'warna_icon' => 'text-indigo-600',
                'urutan' => 2,
                'aktif' => true,
            ],
            [
                'judul' => 'Alumni Tersebar',
                'jumlah' => '4,800+',
                'deskripsi' => 'Alumni yang tersebar di berbagai tempat',
                'ikon' => 'users',
                'warna_icon' => 'text-emerald-600',
                'urutan' => 3,
                'aktif' => true,
            ],
            [
                'judul' => 'Raihan Prestasi',
                'jumlah' => '125+',
                'deskripsi' => 'Prestasi akademik dan non-akademik',
                'ikon' => 'bolt',
                'warna_icon' => 'text-rose-600',
                'urutan' => 4,
                'aktif' => true,
            ],
        ];

        foreach ($data as $item) {
            Statistik::create($item);
        }
    }
}
