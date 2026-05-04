<?php

namespace App\Filament\Resources\TshirtSizeResource\Pages;

use App\Filament\Resources\TshirtSizeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTshirtSizes extends ListRecords
{
    protected static string $resource = TshirtSizeResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
