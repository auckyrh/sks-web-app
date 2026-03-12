<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventPeriodResource\Pages;
use App\Filament\Resources\EventPeriodResource\RelationManagers;
use App\Models\EventPeriod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EventPeriodResource extends Resource
{
    protected static ?string $model = EventPeriod::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'Event Management';
    protected static ?string $navigationLabel = 'Event Period';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Event')
                ->columns(['sm' => 1, 'xl' => 2])
                ->schema([
                    // Left column: text fields
                    Forms\Components\Group::make([
                        Forms\Components\TextInput::make('year')
                            ->label('Tahun')
                            ->numeric()
                            ->minValue(2008)
                            ->required(),
                        Forms\Components\TextInput::make('theme')
                            ->label('Tema')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif (Tahun Berjalan)')
                            ->helperText('Hanya 1 event yang bisa aktif dalam satu waktu bersamaan')
                            ->onColor('success')
                            ->offColor('gray'),
                    ])->columnSpan(['sm' => 1, 'xl' => 1]),

                    // Right column: logo upload
                    Forms\Components\FileUpload::make('event_logo')
                        ->label('Logo Event')
                        ->image()
                        ->nullable()
                        ->directory('event-logos')
                        ->columnSpan(['sm' => 1, 'xl' => 1]),
                ]),

            Forms\Components\Section::make('Tanggal Pelaksanaan')
                ->schema([
                    Forms\Components\DatePicker::make('event_start_date')
                        ->label('Tanggal Mulai Event')
                        ->native(false)
                        ->displayFormat('d M Y'),
                    Forms\Components\DatePicker::make('event_end_date')
                        ->label('Tanggal Selesai Event')
                        ->native(false)
                        ->displayFormat('d M Y')
                        ->afterOrEqual('event_start_date'),
                ])->columns(2),

            Forms\Components\Section::make('Periode Pendaftaran')
                ->schema([
                    Forms\Components\DateTimePicker::make('registration_open_at')
                        ->label('Pendaftaran Dibuka')
                        ->native(false)
                        ->displayFormat('d M Y, H:i'),
                    Forms\Components\DateTimePicker::make('registration_close_at')
                        ->label('Pendaftaran Ditutup')
                        ->native(false)
                        ->displayFormat('d M Y, H:i')
                        ->afterOrEqual('registration_open_at'),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('event_logo')
                    ->label('')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?name=S&background=random')
                    ->width(40)
                    ->height(40),
                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun / Tema')
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->theme)
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('event_date')
                    ->label('Tanggal Event')
                    ->getStateUsing(function ($record) {
                        if (! $record->event_start_date || ! $record->event_end_date) {
                            return '—';
                        }
                        $start = $record->event_start_date;
                        $end   = $record->event_end_date;
                        return $start->format('d') . '–' . $end->format('d') . ' ' . $end->translatedFormat('F Y');
                    })
                    ->sortable(query: fn (Builder $query, string $direction) => $query->orderBy('event_start_date', $direction)),
                Tables\Columns\TextColumn::make('payment_tiers_display')
                    ->label('Biaya')
                    ->html()
                    ->getStateUsing(function ($record) {
                        if ($record->paymentTiers->isEmpty()) {
                            return '<span style="color:#9ca3af;font-size:12px;">—</span>';
                        }
                        return $record->paymentTiers
                            ->sortBy('valid_from')
                            ->map(function ($tier) {
                                [$bg, $color] = str_contains(strtolower($tier->name), 'early')
                                    ? ['#dcfce7', '#16a34a']
                                    : ['#dbeafe', '#2563eb'];
                                $amount = 'Rp ' . number_format($tier->amount, 0, ',', '.');
                                return '
                                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:3px;">
                                        <span style="background:' . $bg . ';color:' . $color . ';padding:1px 8px;border-radius:9999px;font-size:11px;font-weight:600;white-space:nowrap;">'
                                            . e($tier->name) .
                                        '</span>
                                        <span style="font-size:12px;color:#374151;font-weight:500;">' . $amount . '</span>
                                    </div>';
                            })->join('');
                    }),
                Tables\Columns\TextColumn::make('event_classes_display')
                    ->label('Kelas')
                    ->html()
                    ->getStateUsing(function ($record) {
                        if ($record->eventClasses->isEmpty()) {
                            return '<span style="color:#9ca3af;font-size:12px;">—</span>';
                        }
                        $palette = [
                            'kecil'  => ['#dcfce7', '#16a34a', 'Kecil'],
                            'tengah' => ['#fef3c7', '#d97706', 'Tengah'],
                            'besar'  => ['#fee2e2', '#dc2626', 'Besar'],
                        ];
                        $order = ['kecil' => 0, 'tengah' => 1, 'besar' => 2];
                        return $record->eventClasses
                            ->sortBy(fn ($c) => $order[$c->level] ?? 99)
                            ->map(function ($class) use ($palette) {
                                [$bg, $color, $label] = $palette[$class->level]
                                    ?? ['#f3f4f6', '#374151', ucfirst($class->level)];
                                return '
                                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:3px;">
                                        <span style="background:' . $bg . ';color:' . $color . ';padding:1px 8px;border-radius:4px;font-size:11px;font-weight:600;white-space:nowrap;">'
                                            . $label .
                                        '</span>
                                        <span style="font-size:12px;color:#6b7280;">' . e($class->saint_name) . '</span>
                                    </div>';
                            })->join('');
                    }),
                Tables\Columns\TextColumn::make('registration_open_at')
                    ->label('Pendaftaran Dibuka')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('registration_close_at')
                    ->label('Pendaftaran Ditutup')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('year', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('event_classes')
                        ->label('Kelas')
                        ->icon('heroicon-o-academic-cap')
                        ->color('info')
                        ->url(fn ($record) => EventPeriodResource::getUrl('edit', ['record' => $record, 'activeRelationManager' => 0])),
                    Tables\Actions\Action::make('payment_tiers')
                        ->label('Biaya')
                        ->icon('heroicon-o-banknotes')
                        ->color('success')
                        ->url(fn ($record) => EventPeriodResource::getUrl('edit', ['record' => $record, 'activeRelationManager' => 1])),
                    Tables\Actions\Action::make('gatherings')
                        ->label('Gathering')
                        ->icon('heroicon-o-calendar-days')
                        ->color('warning')
                        ->url(fn ($record) => EventPeriodResource::getUrl('edit', ['record' => $record, 'activeRelationManager' => 2])),
                ])
                    ->color('info')
                    ->link()
                    ->label('Kelola')
                    ->icon('heroicon-o-squares-2x2')
                    ->tooltip('Kelola Relasi'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['paymentTiers', 'eventClasses']);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\EventClassesRelationManager::class,
            RelationManagers\PaymentTiersRelationManager::class,
            RelationManagers\GatheringsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventPeriods::route('/'),
            'create' => Pages\CreateEventPeriod::route('/create'),
            'edit' => Pages\EditEventPeriod::route('/{record}/edit'),
        ];
    }
}
