<?php

namespace App\Filament\Resources\MediaVideoResource\Pages;

use App\Filament\Resources\MediaVideoResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Validation\ValidationException;

class EditMediaVideo extends EditRecord
{
    protected static string $resource = MediaVideoResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['youtube_url'])) {
            $extracted = $this->extractYouTubeId($data['youtube_url']);
            if (!$extracted) {
                throw ValidationException::withMessages([
                    'youtube_url' => 'URL YouTube tidak valid. Pastikan formatnya benar.',
                ]);
            }
            $data['youtube_id'] = $extracted;
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
