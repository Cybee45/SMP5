<?php

namespace App\Filament\Resources\ProfileSettingsResource\Pages;

use App\Filament\Resources\ProfileSettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfileSettings extends ListRecords
{
    protected static string $resource = ProfileSettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Tidak ada tombol create karena user hanya edit profile sendiri
        ];
    }
}
