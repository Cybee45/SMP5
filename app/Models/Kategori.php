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
