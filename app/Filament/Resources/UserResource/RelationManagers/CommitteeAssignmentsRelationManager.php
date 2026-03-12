<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommitteeAssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'committeeAssignments';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('event_period_id')
                ->label('Event Period')
                ->relationship('eventPeriod', 'year')
                ->required()
                ->native(false)
                ->preload(),
            Forms\Components\Select::make('division_id')
                ->label('Divisi')
                ->relationship('division', 'name')
                ->required()
                ->native(false)
                ->preload(),
            Forms\Components\Select::make('position')
                ->label('Posisi')
                ->options([
                    'coordinator' => 'Coordinator',
                    'regular'     => 'Regular',
                ])
                ->required()
                ->native(false),
            Forms\Components\Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('eventPeriod.year')
                    ->label('Tahun')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('division.name')
                    ->label('Divisi'),
                Tables\Columns\BadgeColumn::make('position')
                    ->label('Posisi')
                    ->colors([
                        'primary' => 'coordinator',
                        'gray'    => 'regular',
                    ]),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
