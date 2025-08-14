<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SpmhContent extends Model
{
    use HasUuids;

    protected $fillable = [
        'jenis',
        'judul',
        'deskripsi',
        'konten',
        'urutan',
        'aktif',
        'file_pdf',
        'nama_file',
        // Fields untuk Persyaratan
        'deskripsi_pembuka',
        'dokumen_wajib',
        'dokumen_pendukung',
        'ketentuan_berkas',
        'catatan_penting',
        // Fields untuk Tata Cara
        'tahap_persiapan',
        'tahap_pendaftaran',
        'tahap_seleksi',
        'tahap_pengumuman',
        'jadwal_penting',
        'tips_sukses',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'konten' => 'array',
        'dokumen_wajib' => 'array',
        'dokumen_pendukung' => 'array', 
        'ketentuan_berkas' => 'array',
        'tahap_persiapan' => 'array',
        'tahap_pendaftaran' => 'array',
        'tahap_seleksi' => 'array',
        'tahap_pengumuman' => 'array',
        'jadwal_penting' => 'array',
        'tips_sukses' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }

    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }
}
