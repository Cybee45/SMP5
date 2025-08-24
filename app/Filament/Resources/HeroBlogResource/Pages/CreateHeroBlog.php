<?php

namespace App\Filament\Resources\HeroBlogResource\Pages;

use App\Filament\Resources\HeroBlogResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateHeroBlog extends CreateRecord
{
    protected static string $resource = HeroBlogResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['uuid_id'] = Str::uuid();
        return $data;
    }
}
