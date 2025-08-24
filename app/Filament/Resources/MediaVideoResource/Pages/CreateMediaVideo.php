<?php

namespace App\Filament\Resources\MediaVideoResource\Pages;

use App\Filament\Resources\MediaVideoResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateMediaVideo extends CreateRecord
{
    protected static string $resource = MediaVideoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['youtube_id'] = $data['youtube_id'] ?? $this->extractYouTubeId($data['youtube_url'] ?? null);

        if (empty($data['youtube_id'])) {
            throw ValidationException::withMessages([
                'youtube_url' => 'URL YouTube tidak valid. Pastikan formatnya benar.',
            ]);
        }

        return $data;
    }

    private function extractYouTubeId(?string $url): ?string
    {
        if (!$url) return null;
        $patterns = [
            '/youtu\.be\/([a-zA-Z0-9_-]{11})/',
            '/v=([a-zA-Z0-9_-]{11})/',
            '/embed\/([a-zA-Z0-9_-]{11})/',
            '/shorts\/([a-zA-Z0-9_-]{11})/',
        ];
        foreach ($patterns as $p) {
            if (preg_match($p, $url, $m)) return $m[1];
        }
        if (preg_match('/^[a-zA-Z0-9_-]{11}$/', $url)) return $url;
        return null;
    }
}
