<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamAssignmentConstraintResource\Pages;
use App\Models\EventPeriod;
use App\Models\Team;
use App\Models\TeamAssignmentConstraint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TeamAssignmentConstraintResource extends Resource
{
    protected static ?string $model = TeamAssignmentConstraint::class;

    protected static ?string $navigationIcon  = 'heroicon-o-lock-closed';
    protected static ?string $navigationGroup = 'Data Pendaftaran / Peserta';
    protected static ?string $navigationLabel = 'Constraint Tim';
    protected static ?int    $navigationSort  = 5;

    protected static ?string $modelLabel       = 'Constraint';
    protected static ?string $pluralModelLabel = 'Constraints Tim';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('event_period_id')
                ->label('Periode')
                ->relationship('eventPeriod', 'year')
                ->required()
                ->native(false)
                ->default(fn () => EventPeriod::where('is_active', true)->value('id')),

            Forms\Components\Select::make('type')
                ->label('Tipe Constraint')
                ->options([
                    'same_team'  => 'Same Team — harus satu kelompok',
                    'fixed_team' => 'Fixed Team — harus di tim tertentu',
                ])
                ->required()
                ->native(false)
                ->live(),

            Forms\Components\TagsInput::make('registration_numbers')
                ->label('Nomor Registrasi')
                ->helperText('Masukkan nomor registrasi satu per satu. Contoh: SKS-2026-0280')
                ->placeholder('SKS-2026-XXXX')
                ->required(),

            Forms\Components\Select::make('fixed_team_id')
                ->label('Tim yang Dituju')
                ->helperText('Hanya diisi jika tipe = Fixed Team.')
                ->options(fn () => Team::with('eventClass')
                    ->orderBy('number')
                    ->get()
                    ->mapWithKeys(fn ($t) => [
                        $t->id => "[{$t->eventClass?->saint_name}] {$t->name}",
                    ])
                )
                ->native(false)
                ->searchable()
                ->visible(fn (Get $get) => $get('type') === 'fixed_team')
                ->required(fn (Get $get) => $get('type') === 'fixed_team'),

            Forms\Components\Textarea::make('notes')
                ->label('Catatan / Alasan')
                ->helperText('Tulis alasannya agar mudah dimengerti tahun depan.')
                ->rows(3)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('eventPeriod.year')
                    ->label('Periode')
                    ->badge()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Tipe')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'same_team'  => 'Same Team',
                        'fixed_team' => 'Fixed Team',
                        default      => $state,
                    })
                    ->colors([
                        'info'    => 'same_team',
                        'warning' => 'fixed_team',
                    ]),

                Tables\Columns\TextColumn::make('registration_numbers')
                    ->label('No. Registrasi')
                    ->formatStateUsing(fn ($state) => is_array($state)
                        ? implode(', ', $state)
                        : $state
                    )
                    ->wrap(),

                Tables\Columns\TextColumn::make('fixedTeam.name')
                    ->label('Tim Tujuan')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(60)
                    ->tooltip(fn ($record) => $record->notes)
                    ->placeholder('—'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('event_period_id')
                    ->label('Periode')
                    ->relationship('eventPeriod', 'year'),

                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'same_team'  => 'Same Team',
                        'fixed_team' => 'Fixed Team',
                    ]),
            ])
            ->defaultSort('event_period_id', 'desc')
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
            'index'  => Pages\ListTeamAssignmentConstraints::route('/'),
            'create' => Pages\CreateTeamAssignmentConstraint::route('/create'),
            'edit'   => Pages\EditTeamAssignmentConstraint::route('/{record}/edit'),
        ];
    }
}
