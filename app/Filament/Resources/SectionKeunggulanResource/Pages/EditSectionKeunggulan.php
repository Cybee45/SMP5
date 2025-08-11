<?php

namespace App\Filament\Resources\SectionKeunggulanResource\Pages;

use App\Filament\Resources\SectionKeunggulanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSectionKeunggulan extends EditRecord
{
    protected static string $resource = SectionKeunggulanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
