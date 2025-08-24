<?php

namespace App\Filament\Resources\MediaGaleriResource\Pages;

use App\Filament\Resources\MediaGaleriResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMediaGaleri extends CreateRecord
{
    protected static string $resource = MediaGaleriResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate UUID if not provided
        if (empty($data['uuid_id'])) {
            $data['uuid_id'] = (string) \Illuminate\Support\Str::uuid();
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
