<?php

namespace App\Filament\Resources\MediaGaleriResource\Pages;

use App\Filament\Resources\MediaGaleriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMediaGaleri extends EditRecord
{
    protected static string $resource = MediaGaleriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
