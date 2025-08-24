<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\HasUuid; // hapus baris ini jika tidak memakai trait

class Artikel extends Model
{
    use HasUuid; // hapus baris ini jika tidak memakai trait

    protected $fillable = [
        'uuid_id',
        'judul',
        'slug',
        'konten',
        'gambar',
        'kategori_id',
        'user_id',
        'tanggal_publikasi',
        'status',
        'aktif',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
        'aktif' => 'boolean',
    ];

    /** (Opsional, tapi enak kalau frontend pakai UUID di URL) */
    public function getRouteKeyName(): string
    {
        return 'uuid_id';
    }

    /** Relasi */
    public function kategori()
    {
        return $this->belongsTo(KategoriArtikel::class, 'kategori_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Scopes */
    public function scopeAktif($q)
    {
        return $q->where('aktif', true);
    }

    public function scopePublished($q)
    {
        return $q->where('status', 'published');
    }

    /** 👉 Scope yang baru: urut terbaru duluan */
    public function scopeNewest($q)
    {
        return $q->orderByDesc('tanggal_publikasi')
                 ->orderByDesc('created_at');
    }

    /** Auto-slug saat buat/update */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($artikel) {
            if (empty($artikel->slug) && !empty($artikel->judul)) {
                $artikel->slug = Str::slug($artikel->judul);
            }
        });

        static::updating(function ($artikel) {
            if ($artikel->isDirty('judul') && empty($artikel->slug)) {
                $artikel->slug = Str::slug($artikel->judul);
            }
        });
    }
}
