<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasUuid;
    protected $fillable = [
        'judul',
        'deskripsi_1',
        'deskripsi_2',
        'gambar',
        'link_selengkapnya',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
