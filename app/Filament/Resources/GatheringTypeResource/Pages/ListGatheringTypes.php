<?php

namespace App\Filament\Resources\GatheringTypeResource\Pages;

use App\Filament\Resources\GatheringTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGatheringTypes extends ListRecords
{
    protected static string $resource = GatheringTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
