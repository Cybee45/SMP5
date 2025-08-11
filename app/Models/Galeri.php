<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasUuid;

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'kategori',
        'tanggal',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'aktif' => 'boolean',
    ];

    /**
     * Override getRouteKeyName untuk sementara tetap menggunakan ID
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * Override resolveRouteBinding untuk tetap menggunakan ID
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)->first();
    }
}
