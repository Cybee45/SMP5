<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'heroes';

    protected $fillable = [
        'tipe',
        'judul',
        'subjudul',
        'deskripsi',
        'tombol_teks',
        'tombol_link',
        'gambar',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}

