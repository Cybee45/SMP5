<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasUuid;

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'kategori_id',
        'user_id',
        'tanggal_publikasi',
        'status',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
