<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class AboutHero extends Model
{
    use HasUuid;

    protected $fillable = [
        'subjudul',
        'judul',
        'deskripsi',
        'gambar',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }
}
