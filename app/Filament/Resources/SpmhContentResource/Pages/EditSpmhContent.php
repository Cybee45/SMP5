<?php

namespace App\Filament\Resources\SpmhContentResource\Pages;

use App\Filament\Resources\SpmhContentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSpmhContent extends EditRecord
{
    protected static string $resource = SpmhContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
