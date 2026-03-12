<?php

namespace App\Filament\Resources\EventPeriodResource\Pages;

use App\Filament\Resources\EventPeriodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Livewire\Attributes\Url;

class EditEventPeriod extends EditRecord
{
    protected static string $resource = EventPeriodResource::class;

    #[Url]
    public ?string $activeRelationManager = null;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
