<?php

namespace App\Filament\Resources\EventPeriodResource\Pages;

use App\Filament\Resources\EventPeriodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventPeriod extends EditRecord
{
    protected static string $resource = EventPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
