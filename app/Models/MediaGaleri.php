<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MediaGaleri extends Model
{
    use HasFactory;

    protected $table = 'media_galeris';

    protected $fillable = [
        'uuid_id',
        'judul',
        'deskripsi',
        'gambar',
        'kategori',
        'media_kategori_id',
        'tanggal',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'aktif'   => 'boolean',
        'urutan'  => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid_id';
    }

    protected static function booted()
    {
        static::creating(function (self $m) {
            if (empty($m->uuid_id)) $m->uuid_id = (string) Str::uuid();
        });

        static::saving(function (self $model) {
            if ($model->media_kategori_id && $model->kategoriRef()->exists()) {
                $nama = optional($model->kategoriRef)->nama;
                if ($nama) $model->kategori = $nama;
            }
        });
    }

    public function kategoriRef()
    {
        return $this->belongsTo(MediaKategori::class, 'media_kategori_id');
    }

    public function scopeActive($q)  { return $q->where('aktif', true); }
    public function scopeOrdered($q) { return $q->orderBy('urutan')->orderBy('judul'); }

    public function getGambarUrlAttribute(): ?string
    {
        if (!$this->gambar) return null;
        return str_starts_with($this->gambar, 'http') ? $this->gambar : asset('storage/'.$this->gambar);
    }
}
