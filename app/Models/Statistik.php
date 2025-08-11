<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Statistik extends Model
{
    use HasUuid;
    protected $fillable = [
        'judul',         // Contoh: Siswa Aktif
        'jumlah',        // Contoh: 960
        'deskripsi',     // Contoh: Siswa yang sedang aktif belajar
        'ikon',          // Nama icon SVG (misal: user-group)
        'warna_icon',    // Contoh: text-sky-600
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
