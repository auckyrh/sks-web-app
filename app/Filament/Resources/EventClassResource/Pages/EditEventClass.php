<?php

namespace App\Filament\Resources\EventClassResource\Pages;

use App\Filament\Resources\EventClassResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventClass extends EditRecord
{
    protected static string $resource = EventClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
