<?php

namespace App\Filament\Resources\TshirtSizeResource\Pages;

use App\Filament\Resources\TshirtSizeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTshirtSize extends EditRecord
{
    protected static string $resource = TshirtSizeResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
