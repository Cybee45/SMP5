<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasUuid;

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'kategori',
        'tanggal',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'aktif' => 'boolean',
    ];
}
