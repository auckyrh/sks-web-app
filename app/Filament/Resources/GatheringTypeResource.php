<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GatheringTypeResource\Pages;
use App\Models\GatheringType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GatheringTypeResource extends Resource
{
    protected static ?string $model = GatheringType::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Tipe Gathering';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('slug')
                ->label('Slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->alphaDash()
                ->maxLength(64),
            Forms\Components\TextInput::make('label')
                ->label('Label')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('color')
                ->label('Warna Badge')
                ->options([
                    'primary' => 'Primary (Biru)',
                    'warning' => 'Warning (Kuning)',
                    'success' => 'Success (Hijau)',
                    'info'    => 'Info (Cyan)',
                    'danger'  => 'Danger (Merah)',
                    'gray'    => 'Gray',
                ])
                ->required()
                ->native(false),
            Forms\Components\TextInput::make('order')
                ->label('Urutan')
                ->numeric()
                ->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('label')
                    ->label('Label')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('color')
                    ->label('Warna')
                    ->colors([
                        'primary' => 'primary',
                        'warning' => 'warning',
                        'success' => 'success',
                        'info'    => 'info',
                        'danger'  => 'danger',
                        'gray'    => 'gray',
                    ]),
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
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
            'index'  => Pages\ListGatheringTypes::route('/'),
            'create' => Pages\CreateGatheringType::route('/create'),
            'edit'   => Pages\EditGatheringType::route('/{record}/edit'),
        ];
    }
}
