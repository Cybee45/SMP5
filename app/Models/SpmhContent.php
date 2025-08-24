<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SpmhContent extends Model
{
    protected $fillable = [
        'uuid_id',
        'jenis',
        'judul',
        'deskripsi',
        'konten',
        'urutan',
        'aktif',
        'file_pdf',
        'nama_file',

        // Persyaratan
        'deskripsi_pembuka',
        'dokumen_wajib',
        'dokumen_pendukung',
        'ketentuan_berkas',
        'catatan_penting',

        // Tata Cara
        'tahap_persiapan',
        'tahap_pendaftaran',
        'tahap_seleksi',
        'tahap_pengumuman',
        'jadwal_penting',
        'tips_sukses',
    ];

    protected $casts = [
        'aktif'             => 'boolean',
        'urutan'            => 'integer',
        'konten'            => 'array',
        'dokumen_wajib'     => 'array',
        'dokumen_pendukung' => 'array',
        'ketentuan_berkas'  => 'array',
        'tahap_persiapan'   => 'array',
        'tahap_pendaftaran' => 'array',
        'tahap_seleksi'     => 'array',
        'tahap_pengumuman'  => 'array',
        'jadwal_penting'    => 'array',
        'tips_sukses'       => 'array',
    ];

    // route model binding pakai uuid_id
    public function getRouteKeyName(): string
    {
        return 'uuid_id';
    }

    // isi uuid_id otomatis jika kosong
    protected static function booted(): void
    {
        static::creating(function (self $m) {
            if (empty($m->uuid_id)) {
                $m->uuid_id = (string) Str::uuid();
            }
        });
    }

    // scopes
    public function scopeActive($q)  { return $q->where('aktif', true); }
    public function scopeOrdered($q) { return $q->orderBy('urutan'); }
    public function scopeByJenis($q, $jenis) { return $q->where('jenis', $jenis); }
}
