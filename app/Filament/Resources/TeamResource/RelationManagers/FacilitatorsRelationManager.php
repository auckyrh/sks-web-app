<?php

namespace App\Filament\Resources\TeamResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FacilitatorsRelationManager extends RelationManager
{
    protected static string $relationship = 'facilitators';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->label('Pendamping')
                ->options(function () {
                    $activePeriod = \App\Models\EventPeriod::where('is_active', true)->first();
                    if (!$activePeriod) return [];

                    return \App\Models\User::whereHas('committeeAssignments', fn($q) =>
                    $q->where('event_period_id', $activePeriod->id)
                        ->whereHas('division', fn($q2) =>
                        $q2->where('name', 'Pendamping')
                        )
                    )->pluck('full_name', 'id');
                })
                ->required()
                ->searchable(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('full_name')
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nama Pendamping'),
                Tables\Columns\TextColumn::make('nick_name')
                    ->label('Panggilan'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('WhatsApp'),
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->label('Tambah Pendamping')
                    ->preloadRecordSelect()
                    ->recordSelectOptionsQuery(fn ($query) =>
                    $query->whereHas('committeeAssignments', fn($q) =>
                    $q->whereHas('eventPeriod', fn($q2) =>
                    $q2->where('is_active', true)
                    )->whereHas('division', fn($q3) =>
                    $q3->where('name', 'Pendamping')
                    )
                    )
                    )
                    ->recordTitleAttribute('full_name'),
            ])
            ->actions([
                Tables\Actions\DetachAction::make()->label('Lepas'),
            ])
            ->bulkActions([
                Tables\Actions\DetachBulkAction::make(),
            ]);
    }
}
