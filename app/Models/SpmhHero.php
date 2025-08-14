<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SpmhHero extends Model
{
    use HasUuids;

    protected $fillable = [
        'subtitle',
        'title', 
        'description',
        'image_utama',
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
