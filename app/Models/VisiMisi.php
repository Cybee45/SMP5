<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class VisiMisi extends Model
{
    use HasUuid;

    protected $fillable = [
        'judul_section',
        'subjudul_section',
        'visi',
        'misi',
        'tujuan',
        'aktif'
    ];

    protected $casts = [
        'misi' => 'array',
        'tujuan' => 'array',
        'aktif' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }
}
