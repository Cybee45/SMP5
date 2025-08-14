<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class MediaVideo extends Model
{
    use HasUuid;

    protected $fillable = [
        'judul',
        'deskripsi',
        'youtube_url',
        'youtube_id',
        'thumbnail',
        'urutan',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($video) {
            if ($video->youtube_url) {
                $video->youtube_id = self::extractYouTubeId($video->youtube_url);
            }
        });
    }

    public static function extractYouTubeId($url)
    {
        $pattern = '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/';
        preg_match($pattern, $url, $matches);
        return $matches[1] ?? null;
    }

    public function getEmbedUrlAttribute()
    {
        return $this->youtube_id ? "https://www.youtube.com/embed/{$this->youtube_id}" : null;
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        
        return $this->youtube_id ? "https://img.youtube.com/vi/{$this->youtube_id}/maxresdefault.jpg" : null;
    }

    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('created_at', 'desc');
    }
}
