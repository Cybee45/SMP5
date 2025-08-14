<?php

namespace App\Filament\Resources\PrestasiAboutResource\Pages;

use App\Filament\Resources\PrestasiAboutResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPrestasiAbout extends EditRecord
{
    protected static string $resource = PrestasiAboutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
