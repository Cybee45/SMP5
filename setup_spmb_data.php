<?php
/**
 * Script untuk menambahkan data sample SPMB Content termasuk formulir
 */

require_once __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== MENAMBAHKAN DATA SAMPLE SPMB CONTENT ===\n\n";

// Menambahkan atau update data formulir
echo "1. Menambahkan/Update data formulir...\n";

$formulir = App\Models\SpmhContent::where('jenis', 'formulir')->first();

if (!$formulir) {
    $formulir = App\Models\SpmhContent::create([
        'jenis' => 'formulir',
        'judul' => 'Unduh Formulir Pendaftaran',
        'deskripsi' => 'Silakan unduh, cetak, dan isi formulir pendaftaran secara lengkap dan benar.',
        'urutan' => 3,
        'aktif' => true,
        'nama_file' => 'Formulir-Pendaftaran-SMPN5-2025.pdf',
        // file_pdf akan diisi setelah upload melalui admin
    ]);
    echo "   ✅ Data formulir berhasil dibuat dengan ID: {$formulir->id}\n";
} else {
    $formulir->update([
        'judul' => 'Unduh Formulir Pendaftaran',
        'deskripsi' => 'Silakan unduh, cetak, dan isi formulir pendaftaran secara lengkap dan benar.',
        'nama_file' => 'Formulir-Pendaftaran-SMPN5-2025.pdf',
    ]);
    echo "   ✅ Data formulir berhasil diupdate dengan ID: {$formulir->id}\n";
}

// Menambahkan atau update data persyaratan
echo "\n2. Menambahkan/Update data persyaratan...\n";

$persyaratan = App\Models\SpmhContent::where('jenis', 'persyaratan')->first();

if (!$persyaratan) {
    $persyaratan = App\Models\SpmhContent::create([
        'jenis' => 'persyaratan',
        'judul' => 'Persyaratan Pendaftaran',
        'deskripsi' => 'Pastikan semua dokumen yang diperlukan sudah lengkap sebelum mendaftar.',
        'urutan' => 1,
        'aktif' => true,
        'deskripsi_pembuka' => 'Harap mempersiapkan dokumen-dokumen berikut dalam bentuk fisik dan digital untuk keperluan pendaftaran siswa baru tahun ajaran 2025/2026:',
        'dokumen_wajib' => [
            ['item' => 'Fotokopi Akta Kelahiran yang telah dilegalisir (2 lembar)'],
            ['item' => 'Fotokopi Kartu Keluarga (KK) terbaru yang telah dilegalisir (2 lembar)'],
            ['item' => 'Pas foto berwarna ukuran 3x4 dengan latar belakang biru (4 lembar)'],
            ['item' => 'Fotokopi Ijazah SD/MI yang telah dilegalisir oleh sekolah asal (2 lembar)'],
            ['item' => 'Surat Keterangan Lulus (SKL) asli dari sekolah asal'],
            ['item' => 'Fotokopi KTP kedua orang tua/wali yang masih berlaku (masing-masing 2 lembar)'],
            ['item' => 'Surat pernyataan orang tua/wali bermaterai 10.000'],
        ],
        'dokumen_pendukung' => [
            ['item' => 'Fotokopi SHUN/Nilai UN SD/MI (jika ada)'],
            ['item' => 'Sertifikat prestasi akademik atau non-akademik (jika ada)'],
            ['item' => 'Surat keterangan tidak mampu dari kelurahan (untuk jalur khusus)'],
            ['item' => 'Surat keterangan sehat dari dokter'],
            ['item' => 'Surat keterangan kelakuan baik dari sekolah asal'],
        ],
        'ketentuan_berkas' => [
            ['item' => 'Semua berkas dimasukkan ke dalam map plastik berwarna biru untuk laki-laki dan merah muda untuk perempuan'],
            ['item' => 'Berkas yang sudah diserahkan tidak dapat dikembalikan'],
            ['item' => 'Pastikan semua fotokopi jelas dan dapat dibaca dengan baik'],
            ['item' => 'Berkas yang tidak lengkap akan dikembalikan'],
        ],
        'catatan_penting' => '<strong>Penting:</strong> Harap cek kembali kelengkapan berkas sebelum diserahkan ke panitia pendaftaran. Berkas yang tidak lengkap akan memperlambat proses verifikasi.',
    ]);
    echo "   ✅ Data persyaratan berhasil dibuat dengan ID: {$persyaratan->id}\n";
} else {
    echo "   ℹ️  Data persyaratan sudah ada dengan ID: {$persyaratan->id}\n";
}

// Menambahkan atau update data tata cara
echo "\n3. Menambahkan/Update data tata cara...\n";

$tataCara = App\Models\SpmhContent::where('jenis', 'tata_cara')->first();

if (!$tataCara) {
    $tataCara = App\Models\SpmhContent::create([
        'jenis' => 'tata_cara',
        'judul' => 'Tata Cara Pendaftaran',
        'deskripsi' => 'Ikuti alur pendaftaran dengan benar untuk memperlancar proses seleksi.',
        'urutan' => 2,
        'aktif' => true,
        'deskripsi_pembuka' => 'Berikut adalah alur lengkap pendaftaran siswa baru SMPN 5 Sangatta Utara tahun ajaran 2025/2026 secara online dan offline:',
        'tahap_persiapan' => [
            ['item' => '<strong>Unduh Formulir Pendaftaran:</strong> Calon siswa atau orang tua dapat mengunduh formulir dari website resmi sekolah atau mengambil langsung di sekretariat sekolah.'],
            ['item' => '<strong>Baca Ketentuan:</strong> Pahami dengan seksama semua ketentuan dan persyaratan yang telah ditetapkan.'],
            ['item' => '<strong>Siapkan Dokumen:</strong> Kumpulkan dan lengkapi semua dokumen persyaratan sesuai dengan checklist yang telah disediakan.'],
        ],
        'tahap_pendaftaran' => [
            ['item' => '<strong>Isi Formulir:</strong> Cetak dan isi formulir pendaftaran dengan data yang benar, lengkap, dan menggunakan tinta hitam atau biru.'],
            ['item' => '<strong>Verifikasi Data:</strong> Pastikan semua data yang diisi sudah sesuai dengan dokumen asli dan tidak ada kesalahan penulisan.'],
            ['item' => '<strong>Kunjungi Sekolah:</strong> Datang ke sekretariat pendaftaran SMPN 5 Sangatta Utara pada hari kerja (Senin-Jumat) pukul 08:00 - 14:00 WITA.'],
            ['item' => '<strong>Serahkan Berkas:</strong> Serahkan formulir dan semua dokumen persyaratan kepada panitia pendaftaran.'],
        ],
        'tahap_seleksi' => [
            ['item' => '<strong>Verifikasi Berkas:</strong> Panitia akan memverifikasi kelengkapan dan keabsahan semua dokumen yang diserahkan.'],
            ['item' => '<strong>Tes Seleksi:</strong> Calon siswa akan mengikuti tes seleksi sesuai dengan jadwal yang telah ditentukan (tes tulis dan wawancara).'],
            ['item' => '<strong>Penilaian:</strong> Tim seleksi akan melakukan penilaian berdasarkan nilai akademik, tes seleksi, dan prestasi.'],
        ],
        'tahap_pengumuman' => [
            ['item' => '<strong>Pengumuman Hasil:</strong> Hasil seleksi akan diumumkan di papan pengumuman sekolah dan website resmi sekolah.'],
            ['item' => '<strong>Daftar Ulang:</strong> Calon siswa yang dinyatakan lulus wajib melakukan daftar ulang sesuai jadwal yang ditentukan.'],
            ['item' => '<strong>Orientasi:</strong> Mengikuti program orientasi siswa baru dan persiapan pembelajaran.'],
        ],
        'jadwal_penting' => [
            ['item' => 'Pendaftaran dibuka mulai tanggal 1 Agustus 2025'],
            ['item' => 'Batas akhir pendaftaran: 31 Agustus 2025'],
            ['item' => 'Pengumuman hasil seleksi: 15 September 2025'],
            ['item' => 'Daftar ulang: 16-20 September 2025'],
        ],
        'tips_sukses' => [
            ['item' => 'Siapkan berkas jauh-jauh hari untuk menghindari keterlambatan'],
            ['item' => 'Datang tepat waktu saat pengumpulan berkas dan tes seleksi'],
            ['item' => 'Hubungi panitia jika ada pertanyaan atau kesulitan'],
            ['item' => 'Ikuti perkembangan informasi melalui website resmi sekolah'],
        ],
    ]);
    echo "   ✅ Data tata cara berhasil dibuat dengan ID: {$tataCara->id}\n";
} else {
    echo "   ℹ️  Data tata cara sudah ada dengan ID: {$tataCara->id}\n";
}

echo "\n=== RINGKASAN DATA SPMB CONTENT ===\n";
$allContent = App\Models\SpmhContent::orderBy('urutan')->get();
foreach ($allContent as $content) {
    echo "- {$content->jenis}: {$content->judul} (ID: {$content->id})\n";
    if ($content->jenis === 'formulir') {
        echo "  File PDF: " . ($content->file_pdf ? $content->file_pdf : 'Belum ada') . "\n";
        echo "  Nama File: " . ($content->nama_file ? $content->nama_file : 'Belum ada') . "\n";
    }
}

echo "\n=== PETUNJUK UPLOAD FORMULIR ===\n";
echo "1. Login ke admin panel: http://127.0.0.1:8000/admin\n";
echo "2. Buka menu 'CMS SPMB' > 'Konten SPMB'\n";
echo "3. Edit record dengan jenis 'formulir'\n";
echo "4. Upload file PDF pada field 'Upload Formulir PDF'\n";
echo "5. Atur nama file download yang diinginkan\n";
echo "6. Simpan perubahan\n";

echo "\n=== SELESAI ===\n";
