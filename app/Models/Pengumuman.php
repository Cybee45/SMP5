<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasUuid;

    protected $fillable = [
        'judul',
        'konten',
        'tanggal_publikasi',
        'tanggal_berakhir',
        'prioritas',
        'status',
        'user_id',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
        'tanggal_berakhir' => 'datetime',
    ];

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
