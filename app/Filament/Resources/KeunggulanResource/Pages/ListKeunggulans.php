<?php

namespace App\Filament\Resources\KeunggulanResource\Pages;

use App\Filament\Resources\KeunggulanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKeunggulans extends ListRecords
{
    protected static string $resource = KeunggulanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Temporarily disable create action to debug
            // Actions\CreateAction::make(),
        ];
    }
}
