<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TshirtSizeResource\Pages;
use App\Models\EventPeriod;
use App\Models\TshirtSize;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TshirtSizeResource extends Resource
{
    protected static ?string $model = TshirtSize::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';
    protected static ?string $navigationGroup = 'Event Management';
    protected static ?string $navigationLabel = 'Event\'s T-shirt Size';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Ukuran')->schema([
                Forms\Components\Select::make('event_period_id')
                    ->label('Event Period')
                    ->options(EventPeriod::orderByDesc('year')->pluck('year', 'id'))
                    ->required()
                    ->native(false)
                    ->default(fn () => EventPeriod::where('is_active', true)->first()?->id),
                Forms\Components\Select::make('category')
                    ->label('Kategori')
                    ->options(['kids' => 'Anak', 'adult' => 'Dewasa'])
                    ->required()
                    ->native(false),
                Forms\Components\TextInput::make('code')
                    ->label('Kode')
                    ->required()
                    ->maxLength(20)
                    ->placeholder('S, XL, M-Dewasa, …'),
                Forms\Components\TextInput::make('label')
                    ->label('Label')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('S (Anak), XL Dewasa, …'),
                Forms\Components\TextInput::make('panjang')
                    ->label('Panjang (cm)')
                    ->numeric()
                    ->required()
                    ->minValue(1),
                Forms\Components\TextInput::make('lebar')
                    ->label('Lebar (cm)')
                    ->numeric()
                    ->required()
                    ->minValue(1),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('eventPeriod.year')
                    ->label('Period')
                    ->badge()
                    ->color('warning')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('category')
                    ->label('Kategori')
                    ->formatStateUsing(fn ($state) => $state === 'kids' ? 'Anak' : 'Dewasa')
                    ->colors(['info' => 'kids', 'success' => 'adult']),
                Tables\Columns\TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('label')
                    ->label('Label')
                    ->searchable(),
                Tables\Columns\TextColumn::make('panjang')
                    ->label('Panjang')
                    ->formatStateUsing(fn ($state) => "{$state} cm"),
                Tables\Columns\TextColumn::make('lebar')
                    ->label('Lebar')
                    ->formatStateUsing(fn ($state) => "{$state} cm"),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('event_period_id')
                    ->label('Period')
                    ->options(EventPeriod::orderByDesc('year')->pluck('year', 'id'))
                    ->default(fn () => EventPeriod::where('is_active', true)->first()?->id),
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(['kids' => 'Anak', 'adult' => 'Dewasa']),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTshirtSizes::route('/'),
            'create' => Pages\CreateTshirtSize::route('/create'),
            'edit'   => Pages\EditTshirtSize::route('/{record}/edit'),
        ];
    }
}
