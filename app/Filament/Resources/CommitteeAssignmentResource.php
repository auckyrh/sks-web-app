<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommitteeAssignmentResource\Pages;
use App\Filament\Resources\CommitteeAssignmentResource\RelationManagers;
use App\Models\CommitteeAssignment;
use App\Models\EventPeriod;
use App\Models\TshirtSize;
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
            Forms\Components\Section::make('Data Penugasan')->schema([

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
                Forms\Components\Select::make('tshirt_size_id')
                    ->label('Ukuran Kaos')
                    ->options(fn (Forms\Get $get) => TshirtSize::where('event_period_id', $get('event_period_id') ?? EventPeriod::where('is_active', true)->value('id'))
                        ->where('is_active', true)
                        ->orderBy('sort_order')
                        ->get()
                        ->mapWithKeys(fn ($s) => [$s->id => "{$s->label} — {$s->panjang}×{$s->lebar} cm"]))
                    ->nullable()
                    ->native(false)
                    ->searchable(),
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
                Tables\Columns\TextColumn::make('tshirtSize.label')
                    ->label('T-shirt Size')
                    ->badge()
                    ->color('warning')
                    ->placeholder('—')
                    ->description(fn ($record) => $record->tshirtSize
                        ? "{$record->tshirtSize->panjang} × {$record->tshirtSize->lebar} cm"
                        : null)
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->defaultSort('eventPeriod.year', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('event_period_id')
                    ->label('Year')
                    ->relationship('eventPeriod', 'year'),
                Tables\Filters\SelectFilter::make('division_id')
                    ->label('Division')
                    ->relationship('division', 'name'),
                Tables\Filters\SelectFilter::make('position')
                    ->label('Position')
                    ->options([
                        'coordinator' => 'Coordinator',
                        'regular'     => 'Regular',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->trueLabel('Active')
                    ->falseLabel('Inactive'),
                Tables\Filters\Filter::make('ukuran_kaos')
                    ->label('T-shirt Size')
                    ->form([
                        Forms\Components\Select::make('size')
                            ->label('T-shirt Size')
                            ->placeholder('All sizes')
                            ->native(false)
                            ->options(function () {
                                $activePeriodId = EventPeriod::where('is_active', true)->value('id');
                                $sizes = $activePeriodId
                                    ? TshirtSize::where('event_period_id', $activePeriodId)
                                        ->where('is_active', true)
                                        ->orderBy('sort_order')
                                        ->get()
                                        ->mapWithKeys(fn ($s) => [$s->id => $s->label])
                                        ->toArray()
                                    : [];
                                return ['__none__' => '— Not set'] + $sizes;
                            }),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $val = $data['size'] ?? null;
                        if ($val === '__none__') return $query->whereNull('committee_assignments.tshirt_size_id');
                        if ($val)                return $query->where('committee_assignments.tshirt_size_id', (int) $val);
                        return $query;
                    })
                    ->indicateUsing(function (array $data): ?string {
                        $val = $data['size'] ?? null;
                        if (! $val) return null;
                        if ($val === '__none__') return 'T-shirt Size: Not set';
                        $size = TshirtSize::find($val);
                        return $size ? 'T-shirt Size: ' . $size->label : null;
                    }),
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
