<?php

namespace App\Filament\Resources\HeroBlogResource\Pages;

use App\Filament\Resources\HeroBlogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHeroBlogs extends ListRecords
{
    protected static string $resource = HeroBlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
