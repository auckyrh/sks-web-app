<?php

namespace App\Filament\Resources\EventPeriodResource\Pages;

use App\Filament\Resources\EventPeriodResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventPeriods extends ListRecords
{
    protected static string $resource = EventPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
