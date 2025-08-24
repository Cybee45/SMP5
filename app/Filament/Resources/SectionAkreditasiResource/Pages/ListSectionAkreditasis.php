<?php

namespace App\Filament\Resources\SectionAkreditasiResource\Pages;

use App\Filament\Resources\SectionAkreditasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSectionAkreditasis extends ListRecords
{
    protected static string $resource = SectionAkreditasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
