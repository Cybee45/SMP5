<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;

class TimBirokrasi extends Model
{
    use HasUuid;

    /**
     * UUID column name for this model
     */
    protected $uuidColumn = 'uuid';

    protected $fillable = [
        'uuid',
        'nama',
        'jabatan',
        'foto',
        'kategori',
        'urutan',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeKepalaSekolah($query)
    {
        return $query->where('kategori', 'kepala_sekolah');
    }

    public function scopeWakilKepala($query)
    {
        return $query->where('kategori', 'wakil_kepala');
    }
}
