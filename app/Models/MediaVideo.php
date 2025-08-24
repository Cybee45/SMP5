<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MediaVideo extends Model
{
    use HasFactory;

    protected $table = 'media_videos';

    protected $fillable = [
        'uuid_id',
        'judul',
        'deskripsi',
        'youtube_url',
        'youtube_id',
        'url_video',
        'thumbnail',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif'  => 'boolean',
        'urutan' => 'integer',
    ];

    /** Pakai uuid_id di URL */
    public function getRouteKeyName(): string
    {
        return 'uuid_id';
    }

    /** ===== Scopes untuk dipakai di Blade / query ===== */
    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }

    // alias kalau ada view lama yang pakai ->aktif()
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderByDesc('created_at');
    }
    /** ================================================== */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($m) {
            if (empty($m->uuid_id)) {
                $m->uuid_id = (string) Str::uuid();
            }

            // sinkron kolom lama
            if (empty($m->url_video) && !empty($m->youtube_url)) {
                $m->url_video = $m->youtube_url;
            }

            if (empty($m->youtube_id) && !empty($m->youtube_url)) {
                $m->youtube_id = self::extractYouTubeId($m->youtube_url);
            }
        });

        static::updating(function ($m) {
            if ($m->isDirty('youtube_url')) {
                $m->url_video  = $m->youtube_url;
                $m->youtube_id = self::extractYouTubeId($m->youtube_url);
            }
        });
    }

    /** Ambil 11-char YouTube ID dari berbagai format URL */
    private static function extractYouTubeId(?string $url): ?string
    {
        if (!$url) return null;

        $patterns = [
            '/youtu\.be\/([a-zA-Z0-9_-]{11})/',
            '/[?&]v=([a-zA-Z0-9_-]{11})/',
            '/embed\/([a-zA-Z0-9_-]{11})/',
            '/shorts\/([a-zA-Z0-9_-]{11})/',
        ];

        foreach ($patterns as $p) {
            if (preg_match($p, $url, $m)) {
                return $m[1];
            }
        }

        // kalau user tempel ID langsung
        return preg_match('/^[a-zA-Z0-9_-]{11}$/', $url) ? $url : null;
    }
}
