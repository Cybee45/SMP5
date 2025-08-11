<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectionKeunggulan extends Model
{
    protected $fillable = [
        'judul_section',
        'deskripsi_section',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
