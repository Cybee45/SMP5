<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class HeroBlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid_id',
        'judul',
        'deskripsi',
        'subjudul',
        'gambar_utama',
        'gambar_dekorasi',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif'  => 'boolean',
        'urutan' => 'integer',
    ];

    /** Pakai uuid_id sebagai kunci route (/edit, /view, dll) */
    public function getRouteKeyName(): string
    {
        return 'uuid_id';
    }

    /** Pastikan setiap record baru punya uuid_id */
    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->uuid_id)) {
                $model->uuid_id = (string) Str::uuid();
            }
        });
    }
}
