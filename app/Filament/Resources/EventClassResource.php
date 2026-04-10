<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventClassResource\Pages;
use App\Models\EventClass;
use App\Models\EventPeriod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventClassResource extends Resource
{
    protected static ?string $model = EventClass::class;

    protected static ?string $navigationIcon  = 'heroicon-o-rectangle-group';
    protected static ?string $navigationGroup = 'Event Management';
    protected static ?string $navigationLabel = 'Event\'s Class';
    protected static ?int $navigationSort     = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Kelas')
                ->schema([
                    Forms\Components\Select::make('event_period_id')
                        ->label('Event Period')
                        ->options(EventPeriod::orderByDesc('year')->pluck('year', 'id'))
                        ->required()
                        ->native(false)
                        ->default(fn () => EventPeriod::where('is_active', true)->first()?->id),
                    Forms\Components\Select::make('level')
                        ->label('Level')
                        ->options([
                            'kecil'  => 'Kecil',
                            'tengah' => 'Tengah',
                            'besar'  => 'Besar',
                        ])
                        ->required()
                        ->native(false),
                    Forms\Components\TextInput::make('saint_name')
                        ->label('Nama Santo / Santa')
                        ->required()
                        ->maxLength(255)
                        ->helperText('Nama pelindung kelas, misal: Santo Yohanes, Santa Maria'),
                    Forms\Components\FileUpload::make('logo')
                        ->label('Logo Kelas')
                        ->image()
                        ->disk('public')
                        ->visibility('public')
                        ->directory('class-logos')
                        ->nullable()
                        ->getUploadedFileNameForStorageUsing(function ($file, Forms\Get $get) {
                            $level = $get('level') ?? 'class';
                            $saint = str_replace(' ', '-', strtolower($get('saint_name') ?? 'unknown'));
                            $ts    = now()->format('Ymd_His');
                            $ext   = $file->getClientOriginalExtension();
                            return "LOGO-{$level}-{$saint}-{$ts}.{$ext}";
                        }),
                ])
                ->columns(2),

            Forms\Components\Section::make('Range Kelas SD')
                ->schema([
                    Forms\Components\Select::make('grade_min')
                        ->label('Kelas Minimum')
                        ->options([1 => 'Kelas 1', 2 => 'Kelas 2', 3 => 'Kelas 3', 4 => 'Kelas 4', 5 => 'Kelas 5', 6 => 'Kelas 6'])
                        ->required()
                        ->native(false)
                        ->helperText('Kelas SD terendah yang masuk kelas ini'),
                    Forms\Components\Select::make('grade_max')
                        ->label('Kelas Maksimum')
                        ->options([1 => 'Kelas 1', 2 => 'Kelas 2', 3 => 'Kelas 3', 4 => 'Kelas 4', 5 => 'Kelas 5', 6 => 'Kelas 6'])
                        ->required()
                        ->native(false)
                        ->helperText('Kelas SD tertinggi yang masuk kelas ini'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('')
                    ->circular()
                    ->defaultImageUrl(null),
                Tables\Columns\TextColumn::make('eventPeriod.year')
                    ->label('Period')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('level')
                    ->label('Level')
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->colors([
                        'success' => 'kecil',
                        'warning' => 'tengah',
                        'danger'  => 'besar',
                    ]),
                Tables\Columns\TextColumn::make('saint_name')
                    ->label('Santo / Santa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grade_min')
                    ->label('Range Kelas')
                    ->formatStateUsing(fn ($state, $record) => "Kelas {$record->grade_min} – {$record->grade_max}"),
                Tables\Columns\TextColumn::make('participants_count')
                    ->label('Peserta')
                    ->counts('participants')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                Tables\Columns\TextColumn::make('teams_count')
                    ->label('Tim')
                    ->counts('teams')
                    ->badge()
                    ->color('indigo')
                    ->sortable(),
            ])
            ->defaultSort('level')
            ->filters([
                Tables\Filters\SelectFilter::make('event_period_id')
                    ->label('Event Period')
                    ->options(EventPeriod::orderByDesc('year')->pluck('year', 'id'))
                    ->default(fn () => EventPeriod::where('is_active', true)->first()?->id),
                Tables\Filters\SelectFilter::make('level')
                    ->label('Level')
                    ->options([
                        'kecil'  => 'Kecil',
                        'tengah' => 'Tengah',
                        'besar'  => 'Besar',
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListEventClasses::route('/'),
            'create' => Pages\CreateEventClass::route('/create'),
            'edit'   => Pages\EditEventClass::route('/{record}/edit'),
        ];
    }
}
