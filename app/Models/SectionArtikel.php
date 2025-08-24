<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionArtikel extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'section_artikels';

    protected $fillable = [
        'judul',
        'deskripsi',
        'jumlah_tampil',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
        'jumlah_tampil' => 'integer',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}
