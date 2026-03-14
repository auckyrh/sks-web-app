<?php

namespace App\Filament\Resources\EventClassResource\Pages;

use App\Filament\Resources\EventClassResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventClasses extends ListRecords
{
    protected static string $resource = EventClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
