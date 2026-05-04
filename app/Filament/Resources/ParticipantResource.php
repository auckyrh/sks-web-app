<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParticipantResource\Pages;
use App\Models\EventClass;
use App\Models\EventPeriod;
use App\Models\Participant;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParticipantResource extends Resource
{
    protected static ?string $model = Participant::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'Data Pendaftaran / Peserta';
    protected static ?string $navigationLabel = 'Peserta (fix)';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Penempatan')
                ->schema([
                    Forms\Components\Select::make('event_period_id')
                        ->label('Event Period')
                        ->options(EventPeriod::orderByDesc('year')->pluck('year', 'id'))
                        ->required()
                        ->native(false)
                        ->live()
                        ->default(fn () => EventPeriod::where('is_active', true)->first()?->id)
                        ->afterStateUpdated(function (Forms\Set $set) {
                            $set('event_class_id', null);
                            $set('team_id', null);
                        }),
                    Forms\Components\Select::make('event_class_id')
                        ->label('Kelas')
                        ->options(fn (Forms\Get $get) => EventClass::where('event_period_id', $get('event_period_id'))
                            ->get()
                            ->mapWithKeys(fn ($c) => [$c->id => "Kelas {$c->level} — {$c->saint_name}"]))
                        ->nullable()
                        ->native(false)
                        ->live()
                        ->afterStateUpdated(fn (Forms\Set $set) => $set('team_id', null)),
                    Forms\Components\Select::make('team_id')
                        ->label('Tim')
                        ->options(fn (Forms\Get $get) => Team::where('event_class_id', $get('event_class_id'))
                            ->pluck('name', 'id'))
                        ->nullable()
                        ->native(false),
                    Forms\Components\Select::make('registration_id')
                        ->label('No. Pendaftaran')
                        ->relationship('registration', 'registration_number')
                        ->searchable()
                        ->nullable()
                        ->native(false)
                        ->helperText('Registrasi asal peserta ini'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Data Anak')
                ->schema([
                    Forms\Components\TextInput::make('child_full_name')
                        ->label('Nama Lengkap')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('nickname')
                        ->label('Nama Panggilan')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('gender')
                        ->label('Jenis Kelamin')
                        ->options(['M' => 'Laki-laki', 'F' => 'Perempuan'])
                        ->required()
                        ->native(false),
                    Forms\Components\DatePicker::make('birth_date')
                        ->label('Tanggal Lahir')
                        ->native(false)
                        ->displayFormat('d M Y')
                        ->required(),
                    Forms\Components\Select::make('grade')
                        ->label('Kelas Saat Ini')
                        ->options([
                            1 => 'Kelas 1', 2 => 'Kelas 2',
                            3 => 'Kelas 3', 4 => 'Kelas 4',
                            5 => 'Kelas 5', 6 => 'Kelas 6',
                        ])
                        ->required()
                        ->native(false),
                    Forms\Components\Select::make('tshirt_size')
                        ->label('Ukuran Kaos')
                        ->options(['S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL', '2XL' => '2XL'])
                        ->required()
                        ->native(false),
                    Forms\Components\TextInput::make('allergies')
                        ->label('Alergi')
                        ->nullable()
                        ->maxLength(255)
                        ->placeholder('Kosongkan jika tidak ada'),
                    Forms\Components\Textarea::make('notes')
                        ->label('Catatan')
                        ->nullable()
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Data Orang Tua / Wali')
                ->schema([
                    Forms\Components\TextInput::make('parent_name')
                        ->label('Nama Orang Tua / Wali')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('parent_whatsapp')
                        ->label('No. WhatsApp')
                        ->tel()
                        ->required()
                        ->maxLength(255),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['eventPeriod', 'eventClass', 'team', 'registration']))
            ->columns([
                Tables\Columns\TextColumn::make('registration.registration_number')
                    ->label('No. Daftar')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('child_full_name')
                    ->label('Nama Anak')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nickname')
                    ->label('Panggilan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\BadgeColumn::make('gender')
                    ->label('L/P')
                    ->formatStateUsing(fn ($state) => $state === 'M' ? 'Laki-laki' : 'Perempuan')
                    ->colors([
                        'info'   => 'M',
                        'danger' => 'F',
                    ]),
                Tables\Columns\TextColumn::make('grade')
                    ->label('Kls SD')
                    ->formatStateUsing(fn ($state) => "Kelas {$state}")
                    ->sortable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Tgl. Lahir')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('eventPeriod.year')
                    ->label('Period')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                Tables\Columns\TextColumn::make('eventClass.saint_name')
                    ->label('Kelas')
                    ->formatStateUsing(fn ($state, $record) => $record->eventClass
                        ? "Kelas {$record->eventClass->level} — {$record->eventClass->saint_name}"
                        : '—')
                    ->badge()
                    ->color('indigo'),
                Tables\Columns\TextColumn::make('team.name')
                    ->label('Tim')
                    ->badge()
                    ->color('success')
                    ->default('—'),
                Tables\Columns\BadgeColumn::make('tshirt_size')
                    ->label('Kaos')
                    ->color('gray'),
                Tables\Columns\TextColumn::make('parent_name')
                    ->label('Orang Tua')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('parent_whatsapp')
                    ->label('WhatsApp')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('allergies')
                    ->label('Alergi')
                    ->default('—')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Didaftarkan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('child_full_name')
            ->defaultPaginationPageOption(50)
            ->filters([
                Tables\Filters\SelectFilter::make('event_period_id')
                    ->label('Event Period')
                    ->options(EventPeriod::orderByDesc('year')->pluck('year', 'id'))
                    ->default(fn () => EventPeriod::where('is_active', true)->first()?->id),
                Tables\Filters\SelectFilter::make('event_class_id')
                    ->label('Kelas')
                    ->options(fn () => EventClass::all()
                        ->mapWithKeys(fn ($c) => [$c->id => "Kelas {$c->level} — {$c->saint_name}"])),
                Tables\Filters\SelectFilter::make('team_id')
                    ->label('Tim')
                    ->options(Team::pluck('name', 'id')),
                Tables\Filters\SelectFilter::make('gender')
                    ->label('Jenis Kelamin')
                    ->options(['M' => 'Laki-laki', 'F' => 'Perempuan']),
                Tables\Filters\SelectFilter::make('tshirt_size')
                    ->label('Ukuran Kaos')
                    ->options(['S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL', '2XL' => '2XL']),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index'  => Pages\ListParticipants::route('/'),
            'create' => Pages\CreateParticipant::route('/create'),
            'edit'   => Pages\EditParticipant::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
