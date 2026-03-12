<?php

namespace App\Filament\Resources\EventPeriodResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GatheringsRelationManager extends RelationManager
{
    protected static string $relationship = 'gatherings';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('gathering_type_id')
                ->label('Tipe')
                ->relationship('gatheringType', 'label', fn ($query) => $query->orderBy('order'))
                ->required()
                ->native(false)
                ->preload(),
            Forms\Components\TextInput::make('name')
                ->label('Nama Gathering')
                ->required()
                ->columnSpanFull(),
            Forms\Components\DateTimePicker::make('date')
                ->label('Tanggal & Waktu')
                ->native(false)
                ->displayFormat('d M Y, H:i')
                ->required(),
            Forms\Components\TextInput::make('location')
                ->label('Lokasi')
                ->required(),
            Forms\Components\Textarea::make('notes')
                ->label('Catatan')
                ->nullable()
                ->columnSpanFull(),
        ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('gatheringType.label')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn ($record) => $record->gatheringType?->color ?? 'gray'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi'),
            ])
            ->defaultSort('date')
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
