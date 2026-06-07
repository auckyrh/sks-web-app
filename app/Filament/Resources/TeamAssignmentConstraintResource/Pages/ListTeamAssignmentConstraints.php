<?php

namespace App\Filament\Resources\TeamAssignmentConstraintResource\Pages;

use App\Filament\Resources\TeamAssignmentConstraintResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeamAssignmentConstraints extends ListRecords
{
    protected static string $resource = TeamAssignmentConstraintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
