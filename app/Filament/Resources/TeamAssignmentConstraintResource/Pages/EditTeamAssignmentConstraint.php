<?php

namespace App\Filament\Resources\TeamAssignmentConstraintResource\Pages;

use App\Filament\Resources\TeamAssignmentConstraintResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTeamAssignmentConstraint extends EditRecord
{
    protected static string $resource = TeamAssignmentConstraintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
