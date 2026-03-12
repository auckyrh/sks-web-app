<?php

namespace App\Filament\Resources\CommitteeAssignmentResource\Pages;

use App\Filament\Resources\CommitteeAssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCommitteeAssignments extends ListRecords
{
    protected static string $resource = CommitteeAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
