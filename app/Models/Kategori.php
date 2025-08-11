<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasUuid;

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function artikel()
    {
        return $this->hasMany(Artikel::class);
    }
}
