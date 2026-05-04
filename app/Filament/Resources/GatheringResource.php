<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GatheringResource\Pages;
use App\Filament\Resources\GatheringResource\RelationManagers;
use App\Models\Gathering;
use App\Models\GatheringType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GatheringResource extends Resource
{
    protected static ?string $model = Gathering::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Event Management';
    protected static ?string $navigationLabel = 'Event\'s Gatherings';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Pertemuan')->schema([
                Forms\Components\Select::make('event_period_id')
                    ->label('Event Period')
                    ->relationship('eventPeriod', 'year')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->year} - {$record->theme}")
                    ->required()
                    ->native(false)
                    ->preload()
                    ->default(fn () => \App\Models\EventPeriod::where('is_active', true)->first()?->id),
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
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('eventPeriod.year')
                    ->label('Tahun')
                    ->sortable()
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gatheringType.label')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn ($record) => $record->gatheringType?->color ?? 'gray')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rsvps_count')
                    ->label('RSVP')
                    ->counts('rsvps')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                Tables\Columns\TextColumn::make('attendances_count')
                    ->label('Hadir')
                    ->counts('attendances')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(40)
                    ->default('—')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('date', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('event_period_id')
                    ->label('Tahun')
                    ->relationship('eventPeriod', 'year'),
                Tables\Filters\SelectFilter::make('gathering_type_id')
                    ->label('Tipe')
                    ->relationship('gatheringType', 'label', fn ($query) => $query->orderBy('order')),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGatherings::route('/'),
            'create' => Pages\CreateGathering::route('/create'),
            'edit' => Pages\EditGathering::route('/{record}/edit'),
        ];
    }
}
