<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventClassResource\Pages;
use App\Filament\Resources\EventClassResource\RelationManagers;
use App\Models\EventClass;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventClassResource extends Resource
{
    protected static ?string $model = EventClass::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('event_period_id')
                    ->relationship('eventPeriod', 'id')
                    ->required(),
                Forms\Components\TextInput::make('level')
                    ->required(),
                Forms\Components\TextInput::make('saint_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('grade_min')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('grade_max')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('eventPeriod.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('level'),
                Tables\Columns\TextColumn::make('saint_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grade_min')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grade_max')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventClasses::route('/'),
            'create' => Pages\CreateEventClass::route('/create'),
            'edit' => Pages\EditEventClass::route('/{record}/edit'),
        ];
    }
}
