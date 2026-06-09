<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Filament\Resources\TeamResource\RelationManagers;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Data Pendaftaran / Peserta';
    protected static ?string $navigationLabel = 'Tim / Kelompok';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Tim')->schema([
                Forms\Components\Select::make('event_period_id')
                    ->label('Event Period')
                    ->relationship('eventPeriod', 'year')
                    ->required()
                    ->native(false)
                    ->preload()
                    ->live()
                    ->default(fn () => \App\Models\EventPeriod::where('is_active', true)->first()?->id),
                Forms\Components\Select::make('event_class_id')
                    ->label('Kelas')
                    ->options(fn (Forms\Get $get) =>
                    \App\Models\EventClass::where('event_period_id', $get('event_period_id'))
                        ->get()
                        ->mapWithKeys(fn ($c) => [
                            $c->id => ucfirst($c->level) . ' — ' . $c->saint_name
                        ])
                    )
                    ->required()
                    ->native(false)
                    ->live(),
                Forms\Components\TextInput::make('number')
                    ->label('Nomor Tim')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Tim')
                    ->required()
                    ->helperText('Contoh: St. Carlo Acutis 1'),
                Forms\Components\TextInput::make('whatsapp_group_link')
                    ->label('Link Grup WhatsApp Orang Tua')
                    ->url()
                    ->nullable()
                    ->placeholder('https://chat.whatsapp.com/...')
                    ->helperText('Link undangan grup WA untuk orang tua peserta kelompok ini.')
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('eventClass.level')
                    ->label('Kelas')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'kecil'  => 'Kelas Kecil',
                        'tengah' => 'Kelas Tengah',
                        'besar'  => 'Kelas Besar',
                        default  => $state,
                    })
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'kecil'  => 'success',
                        'tengah' => 'warning',
                        'besar'  => 'danger',
                        default  => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Kelompok')
                    ->searchable()
                    ->sortable(query: fn (Builder $query, string $direction) =>
                        $query->orderBy('number', $direction)
                    ),
                Tables\Columns\IconColumn::make('whatsapp_group_link')
                    ->label('Grup WA')
                    ->boolean()
                    ->trueIcon('heroicon-o-chat-bubble-left-ellipsis')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('success')
                    ->falseColor('gray'),
                Tables\Columns\TextColumn::make('facilitators_count')
                    ->label('Pendamping')
                    ->counts('facilitators')
                    ->badge()
                    ->color(fn ($state) => $state >= 1 ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('participants_count')
                    ->label('Peserta')
                    ->counts('participants')
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('eventPeriod.year')
                    ->label('Tahun')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
            ])
            ->defaultSort('number')
            ->filters([
                Tables\Filters\SelectFilter::make('event_period_id')
                    ->label('Tahun')
                    ->relationship('eventPeriod', 'year')
                    ->default(\App\Models\EventPeriod::where('is_active', true)->first()?->id),
                Tables\Filters\SelectFilter::make('event_class_id')
                    ->label('Kelas')
                    ->relationship('eventClass', 'saint_name'),
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
            RelationManagers\FacilitatorsRelationManager::class,
            RelationManagers\ParticipantsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeams::route('/'),
            'create' => Pages\CreateTeam::route('/create'),
            'edit' => Pages\EditTeam::route('/{record}/edit'),
        ];
    }
}
