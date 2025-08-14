<?php

namespace App\Filament\Resources\MediaVideoResource\Pages;

use App\Filament\Resources\MediaVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMediaVideo extends EditRecord
{
    protected static string $resource = MediaVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
