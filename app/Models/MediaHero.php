<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class MediaHero extends Model
{
    use HasUuid;

    protected $fillable = [
        'judul_utama',
        'subjudul',
        'deskripsi',
        'gambar_hero',
        'gambar_globe',
        'gambar_wave',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean'
    ];

    public function getGambarHeroUrlAttribute()
    {
        return $this->gambar_hero ? asset('storage/' . $this->gambar_hero) : asset('assets/media/hero.png');
    }

    public function getGambarGlobeUrlAttribute()
    {
        return $this->gambar_globe ? asset('storage/' . $this->gambar_globe) : asset('assets/media/globe.png');
    }

    public function getGambarWaveUrlAttribute()
    {
        return $this->gambar_wave ? asset('storage/' . $this->gambar_wave) : asset('assets/media/wave.png');
    }

    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }
}
