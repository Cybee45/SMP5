<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriArtikel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategoris';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'warna',
        'icon',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    public function artikels()
    {
        return $this->hasMany(Artikel::class, 'kategori_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function getArtikelCountAttribute()
    {
        return $this->artikels()->count();
    }
}
