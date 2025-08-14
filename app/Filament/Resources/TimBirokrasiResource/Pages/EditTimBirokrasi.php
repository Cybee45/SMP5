<?php

namespace App\Filament\Resources\TimBirokrasiResource\Pages;

use App\Filament\Resources\TimBirokrasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimBirokrasi extends EditRecord
{
    protected static string $resource = TimBirokrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
