<?php

namespace App\Filament\Resources\GatheringResource\Pages;

use App\Filament\Resources\GatheringResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGatherings extends ListRecords
{
    protected static string $resource = GatheringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
