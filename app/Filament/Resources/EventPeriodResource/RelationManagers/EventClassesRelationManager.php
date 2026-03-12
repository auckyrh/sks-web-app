<?php

namespace App\Filament\Resources\EventPeriodResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventClassesRelationManager extends RelationManager
{
    protected static string $relationship = 'eventClasses';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('level')
                ->label('Kelas')
                ->options([
                    'kecil'  => 'Kelas Kecil (Grade 1-2)',
                    'tengah' => 'Kelas Tengah (Grade 3-4)',
                    'besar'  => 'Kelas Besar (Grade 5-6)',
                ])
                ->required()
                ->native(false),
            Forms\Components\TextInput::make('saint_name')
                ->label('Nama Santo/Santa')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('grade_min')
                ->label('Grade Min')
                ->numeric()
                ->minValue(1)
                ->maxValue(6)
                ->required(),
            Forms\Components\TextInput::make('grade_max')
                ->label('Grade Max')
                ->numeric()
                ->minValue(1)
                ->maxValue(6)
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('level')
                    ->label('Kelas')
                    ->colors([
                        'success' => 'kecil',
                        'warning' => 'tengah',
                        'danger'  => 'besar',
                    ])
                    ->formatStateUsing(fn ($state) => match($state) {
                        'kecil'  => 'Kelas Kecil',
                        'tengah' => 'Kelas Tengah',
                        'besar'  => 'Kelas Besar',
                    }),
                Tables\Columns\TextColumn::make('saint_name')
                    ->label('Nama Santo/Santa'),
                Tables\Columns\TextColumn::make('grade_min')
                    ->label('Grade Min'),
                Tables\Columns\TextColumn::make('grade_max')
                    ->label('Grade Max'),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}
