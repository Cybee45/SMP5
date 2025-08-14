<?php

namespace App\Filament\Resources\SpmhContentResource\Pages;

use App\Filament\Resources\SpmhContentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpmhContents extends ListRecords
{
    protected static string $resource = SpmhContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
