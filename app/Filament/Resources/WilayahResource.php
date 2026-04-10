<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WilayahResource\Pages;
use App\Filament\Resources\WilayahResource\RelationManagers;
use App\Models\Wilayah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class WilayahResource extends Resource
{
    protected static ?string $model = Wilayah::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Wilayah';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Wilayah')
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Wilayah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lingkungan_count')
                    ->label('Lingkungan')
                    ->counts('lingkungan')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->filters([])
            ->actions([
                Tables\Actions\Action::make('see_lingkungan')
                    ->label('Lihat Lingkungan')
                    ->icon('heroicon-o-list-bullet')
                    ->color('info')
                    ->modalHeading(fn ($record) => "Lingkungan — Wilayah {$record->name}")
                    ->modalContent(function ($record) {
                        $record->loadMissing('lingkungan');
                        $items = $record->lingkungan->sortBy('name')->values();

                        if ($items->isEmpty()) {
                            return new HtmlString(
                                '<p class="text-sm text-gray-500 py-4 text-center">Belum ada lingkungan untuk wilayah ini.</p>'
                            );
                        }

                        $rows = $items->map(fn ($l, $i) =>
                            '<tr class="' . ($i % 2 === 0 ? 'bg-white dark:bg-gray-900' : 'bg-gray-50 dark:bg-gray-800') . '">'
                            . '<td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400 w-8">' . ($i + 1) . '</td>'
                            . '<td class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-white">' . e($l->name) . '</td>'
                            . '</tr>'
                        )->implode('');

                        return new HtmlString(
                            '<div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700 mb-2">'
                            . '<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">'
                            . '<thead class="bg-gray-100 dark:bg-gray-700">'
                            . '<tr>'
                            . '<th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase w-8">#</th>'
                            . '<th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase">Nama Lingkungan</th>'
                            . '</tr>'
                            . '</thead>'
                            . '<tbody class="divide-y divide-gray-200 dark:divide-gray-700">'
                            . $rows
                            . '</tbody>'
                            . '</table>'
                            . '</div>'
                            . '<p class="text-xs text-gray-400 text-right">Total: ' . $items->count() . ' lingkungan</p>'
                        );
                    })
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
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
            'index' => Pages\ListWilayahs::route('/'),
            'create' => Pages\CreateWilayah::route('/create'),
            'edit' => Pages\EditWilayah::route('/{record}/edit'),
        ];
    }
}
