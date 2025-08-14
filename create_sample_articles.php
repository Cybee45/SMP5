<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Kategori;
use App\Models\Artikel;

$admin = User::first();
$prestasi = Kategori::where('slug', 'prestasi')->first();
$kegiatan = Kategori::where('slug', 'kegiatan')->first();
$pengumuman = Kategori::where('slug', 'pengumuman')->first();

if ($admin && $prestasi) {
    $artikel1 = Artikel::create([
        'judul' => 'Siswa SMP 5 Raih Juara 1 Olimpiade Matematika Tingkat Provinsi',
        'slug' => 'siswa-smp-5-raih-juara-1-olimpiade-matematika-tingkat-provinsi',
        'konten' => '<p>Prestasi membanggakan kembali ditorehkan oleh siswa SMP 5. Dalam ajang Olimpiade Matematika Tingkat Provinsi yang diselenggarakan pada bulan Juli 2025, siswa kami berhasil meraih juara 1.</p><p>Ahmad Rizki, siswa kelas VIII A, berhasil mengalahkan 150 peserta dari seluruh sekolah di provinsi ini. Prestasi ini merupakan hasil kerja keras dan bimbingan intensif dari guru matematika sekolah.</p><p>"Saya sangat bangga bisa mewakili sekolah dan meraih prestasi ini. Terima kasih untuk dukungan guru dan teman-teman," ujar Ahmad Rizki saat diwawancarai.</p>',
        'kategori_id' => $prestasi->id,
        'user_id' => $admin->id,
        'tanggal_publikasi' => now(),
        'status' => 'published',
        'aktif' => true,
        'meta_description' => 'Siswa SMP 5 meraih juara 1 Olimpiade Matematika Tingkat Provinsi',
        'meta_keywords' => 'olimpiade, matematika, prestasi, juara, SMP 5',
    ]);
    echo "Artikel 1 berhasil dibuat: " . $artikel1->judul . "\n";
}

if ($admin && $kegiatan) {
    $artikel2 = Artikel::create([
        'judul' => 'Pelaksanaan Study Tour ke Museum Nasional Jakarta',
        'slug' => 'pelaksanaan-study-tour-ke-museum-nasional-jakarta',
        'konten' => '<p>Dalam rangka menambah wawasan dan pengetahuan siswa tentang sejarah dan budaya Indonesia, SMP 5 mengadakan study tour ke Museum Nasional Jakarta pada tanggal 10 Agustus 2025.</p><p>Kegiatan ini diikuti oleh 120 siswa kelas VII dan VIII, didampingi oleh 12 guru dan staf sekolah. Siswa mendapat kesempatan untuk melihat langsung koleksi bersejarah dan mengikuti sesi edukasi dari pemandu museum.</p><p>Kepala Sekolah, Bapak Drs. Sujatmiko, M.Pd., menyatakan bahwa kegiatan seperti ini sangat penting untuk mendukung pembelajaran di kelas dan menumbuhkan rasa cinta tanah air pada siswa.</p>',
        'kategori_id' => $kegiatan->id,
        'user_id' => $admin->id,
        'tanggal_publikasi' => now()->subDays(2),
        'status' => 'published',
        'aktif' => true,
        'meta_description' => 'Study tour siswa SMP 5 ke Museum Nasional Jakarta',
        'meta_keywords' => 'study tour, museum, sejarah, edukasi, SMP 5',
    ]);
    echo "Artikel 2 berhasil dibuat: " . $artikel2->judul . "\n";
}

if ($admin && $pengumuman) {
    $artikel3 = Artikel::create([
        'judul' => 'Pengumuman Libur Akhir Semester Ganjil 2024/2025',
        'slug' => 'pengumuman-libur-akhir-semester-ganjil-2024-2025',
        'konten' => '<p>Dengan berakhirnya kegiatan pembelajaran semester ganjil tahun ajaran 2024/2025, SMP 5 mengumumkan jadwal libur semester untuk seluruh siswa.</p><p><strong>Jadwal Libur:</strong></p><ul><li>Mulai: Sabtu, 20 Desember 2024</li><li>Berakhir: Minggu, 5 Januari 2025</li><li>Masuk kembali: Senin, 6 Januari 2025</li></ul><p>Selama masa libur, siswa diharapkan tetap menjaga kesehatan dan melaksanakan tugas liburan yang telah diberikan oleh masing-masing guru mata pelajaran.</p><p>Untuk siswa kelas IX, akan ada kegiatan tambahan persiapan ujian nasional yang jadwalnya akan diinformasikan kemudian.</p>',
        'kategori_id' => $pengumuman->id,
        'user_id' => $admin->id,
        'tanggal_publikasi' => now()->subDays(5),
        'status' => 'published',
        'aktif' => true,
        'meta_description' => 'Pengumuman jadwal libur akhir semester ganjil SMP 5',
        'meta_keywords' => 'libur, semester, pengumuman, jadwal, SMP 5',
    ]);
    echo "Artikel 3 berhasil dibuat: " . $artikel3->judul . "\n";
}

echo "Selesai membuat data artikel sample.\n";
