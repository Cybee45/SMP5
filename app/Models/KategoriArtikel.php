<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriArtikel extends Model
{
    use HasFactory;

    protected $table = 'kategori_artikels';

    protected $fillable = [
        'uuid_id',
        'nama',
        'slug',
        'deskripsi',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif'  => 'boolean',
        'urutan' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid_id';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid_id)) {
                $model->uuid_id = (string) Str::uuid();
            }
            if (empty($model->slug) && !empty($model->nama)) {
                $model->slug = Str::slug($model->nama);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('nama') && empty($model->slug)) {
                $model->slug = Str::slug($model->nama);
            }
        });
    }

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
