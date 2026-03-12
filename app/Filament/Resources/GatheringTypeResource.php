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
                ->allowHtml()
                ->options(fn () => collect(self::registeredColors())
                    ->mapWithKeys(fn ($hex, $name) => [
                        $name => '<div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                                    <span>' . ucfirst($name) . '</span>
                                    <span style="display:inline-block;width:16px;height:16px;border-radius:4px;background:' . $hex . ';flex-shrink:0;"></span>
                                  </div>',
                    ])
                    ->all()
                )
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
                Tables\Columns\TextColumn::make('color')
                    ->label('Warna')
                    ->badge()
                    ->color(fn ($state) => $state),
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

    /** Colors registered in AppServiceProvider — keep in sync. */
    public static function registeredColors(): array
    {
        return [
            'primary' => '#3b82f6',
            'info'    => '#0ea5e9',
            'success' => '#22c55e',
            'warning' => '#f59e0b',
            'danger'  => '#ef4444',
            'gray'    => '#71717a',
            'indigo'  => '#6366f1',
            'violet'  => '#8b5cf6',
            'sky'     => '#0ea5e9',
            'teal'    => '#14b8a6',
            'orange'  => '#f97316',
            'rose'    => '#f43f5e',
        ];
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
