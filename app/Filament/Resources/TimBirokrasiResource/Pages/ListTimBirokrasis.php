<?php

namespace App\Filament\Resources\TimBirokrasiResource\Pages;

use App\Filament\Resources\TimBirokrasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimBirokrasis extends ListRecords
{
    protected static string $resource = TimBirokrasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
