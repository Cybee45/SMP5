<?php

namespace App\Filament\Resources\PrestasiAboutResource\Pages;

use App\Filament\Resources\PrestasiAboutResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrestasiAbouts extends ListRecords
{
    protected static string $resource = PrestasiAboutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
