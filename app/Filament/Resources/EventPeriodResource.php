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
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                ->schema([
                    Forms\Components\TextInput::make('year')
                        ->label('Tahun')
                        ->numeric()
                        ->minValue(2000)
                        ->maxValue(2100)
                        ->required(),
                    Forms\Components\TextInput::make('theme')
                        ->label('Tema')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('event_logo')
                        ->label('Logo Event')
                        ->image()
                        ->nullable()
                        ->directory('event-logos')
                        ->columnSpanFull(),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktif (Tahun Berjalan)')
                        ->helperText('Hanya 1 event yang bisa aktif dalam satu waktu bersamaan')
                        ->onColor('success')
                        ->offColor('gray'),
                ])->columns(2),

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
                    ->label('Tahun')
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('theme')
                    ->label('Tema')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('event_start_date')
                    ->label('Mulai Event')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('event_end_date')
                    ->label('Selesai Event')
                    ->date('d M Y')
                    ->sortable(),
//                Tables\Columns\TextColumn::make('paymentTiers.amount')
//                    ->label('Biaya')
//                    ->money('IDR')
//                    ->listWithLineBreaks()
//                    ->bulleted(),
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
