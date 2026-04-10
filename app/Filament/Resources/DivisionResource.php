<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DivisionResource\Pages;
use App\Filament\Resources\DivisionResource\RelationManagers;
use App\Models\Division;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class DivisionResource extends Resource
{
    protected static ?string $model = Division::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Divisi';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Divisi')
                ->required()
                ->maxLength(255)
                ->helperText('Misal: Acara, Konsumsi, Perlengkapan, Dokumentasi'),
            Forms\Components\Select::make('access_level')
                ->label('Level Akses')
                ->options([
                    'upper' => 'Upper — Akses Penuh',
                    'lower' => 'Lower — Read Only',
                ])
                ->required()
                ->native(false)
                ->helperText('Upper: dapat mengelola data. Lower: hanya bisa melihat.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Divisi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('access_level')
                    ->label('Level Akses')
                    ->colors([
                        'success' => 'upper',
                        'danger'  => 'lower',
                    ])
                    ->formatStateUsing(fn ($state) => $state === 'upper' ? 'Upper' : 'Lower'),
                Tables\Columns\TextColumn::make('committee_assignments_count')
                    ->label('Panitia')
                    ->counts('committeeAssignments')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id')
            ->filters([
                Tables\Filters\SelectFilter::make('access_level')
                    ->label('Level Akses')
                    ->options([
                        'upper' => 'Upper',
                        'lower' => 'Lower',
                    ]),
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
            'index' => Pages\ListDivisions::route('/'),
            'create' => Pages\CreateDivision::route('/create'),
            'edit' => Pages\EditDivision::route('/{record}/edit'),
        ];
    }
}
