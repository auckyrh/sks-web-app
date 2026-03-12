<?php

namespace App\Filament\Resources\GatheringTypeResource\Pages;

use App\Filament\Resources\GatheringTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGatheringType extends EditRecord
{
    protected static string $resource = GatheringTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
