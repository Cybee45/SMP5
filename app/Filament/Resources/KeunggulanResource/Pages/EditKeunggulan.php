<?php

namespace App\Filament\Resources\KeunggulanResource\Pages;

use App\Filament\Resources\KeunggulanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKeunggulan extends EditRecord
{
    protected static string $resource = KeunggulanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
