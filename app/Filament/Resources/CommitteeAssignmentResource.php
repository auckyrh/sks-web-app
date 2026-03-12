<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommitteeAssignmentResource\Pages;
use App\Filament\Resources\CommitteeAssignmentResource\RelationManagers;
use App\Models\CommitteeAssignment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommitteeAssignmentResource extends Resource
{
    protected static ?string $model = CommitteeAssignment::class;
    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'Committee Assignment';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->schema([

                Forms\Components\Select::make('user_id')
                    ->label('Panitia')
                    ->relationship('user', 'full_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('event_period_id')
                    ->label('Event Period')
                    ->relationship('eventPeriod', 'year')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->year} - {$record->theme}")
                    ->required()
                    ->native(false)
                    ->preload()
                    ->default(fn () => \App\Models\EventPeriod::where('is_active', true)->first()?->id),
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
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('eventPeriod.year')
                    ->label('Tahun')
                    ->badge()
                    ->color('warning')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.full_name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('division.name')
                    ->label('Divisi')
                    ->badge()
                    ->color('primary')
                    ->searchable(),
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
            ->defaultSort('eventPeriod.year', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('event_period_id')
                    ->label('Tahun')
                    ->relationship('eventPeriod', 'year'),
                Tables\Filters\SelectFilter::make('division_id')
                    ->label('Divisi')
                    ->relationship('division', 'name'),
                Tables\Filters\SelectFilter::make('position')
                    ->label('Posisi')
                    ->options([
                        'coordinator' => 'Coordinator',
                        'regular'     => 'Regular',
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
            'index' => Pages\ListCommitteeAssignments::route('/'),
            'create' => Pages\CreateCommitteeAssignment::route('/create'),
            'edit' => Pages\EditCommitteeAssignment::route('/{record}/edit'),
        ];
    }
}
