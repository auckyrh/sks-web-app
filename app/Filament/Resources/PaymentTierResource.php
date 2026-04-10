<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentTierResource\Pages;
use App\Models\EventPeriod;
use App\Models\PaymentTier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentTierResource extends Resource
{
    protected static ?string $model = PaymentTier::class;

    protected static ?string $navigationIcon  = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Event Management';
    protected static ?string $navigationLabel = 'Event\'s Payment Tier';
    protected static ?int $navigationSort     = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Tier')
                ->schema([
                    Forms\Components\Select::make('event_period_id')
                        ->label('Event Period')
                        ->options(EventPeriod::orderByDesc('year')->pluck('year', 'id'))
                        ->required()
                        ->native(false)
                        ->default(fn () => EventPeriod::where('is_active', true)->first()?->id),
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Tier')
                        ->required()
                        ->maxLength(255)
                        ->helperText('Misal: Early Bird, Normal, Late'),
                    Forms\Components\TextInput::make('amount')
                        ->label('Nominal (Rp)')
                        ->required()
                        ->numeric()
                        ->prefix('Rp')
                        ->minValue(0)
                        ->helperText('Masukkan nominal tanpa titik atau koma'),
                    Forms\Components\Textarea::make('description')
                        ->label('Keterangan')
                        ->nullable()
                        ->rows(2)
                        ->columnSpanFull()
                        ->helperText('Opsional — keterangan tambahan untuk tier ini'),
                ])
                ->columns(2),

            Forms\Components\Section::make('Periode Berlaku')
                ->schema([
                    Forms\Components\DatePicker::make('valid_from')
                        ->label('Berlaku Mulai')
                        ->required()
                        ->native(false)
                        ->displayFormat('d M Y')
                        ->live(),
                    Forms\Components\DatePicker::make('valid_until')
                        ->label('Berlaku Sampai')
                        ->required()
                        ->native(false)
                        ->displayFormat('d M Y')
                        ->after('valid_from')
                        ->helperText('Harus setelah tanggal mulai'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('eventPeriod.year')
                    ->label('Period')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                Tables\Columns\TextColumn::make('eventPeriod.theme')
                    ->label('Theme')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Tier')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Nominal')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('valid_from')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('valid_until')
                    ->label('Sampai')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Keterangan')
                    ->limit(50)
                    ->default('—')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('valid_from')
            ->filters([
                Tables\Filters\SelectFilter::make('event_period_id')
                    ->label('Event Period')
                    ->options(EventPeriod::orderByDesc('year')->pluck('year', 'id'))
                    ->default(fn () => EventPeriod::where('is_active', true)->first()?->id),
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
            'index'  => Pages\ListPaymentTiers::route('/'),
            'create' => Pages\CreatePaymentTier::route('/create'),
            'edit'   => Pages\EditPaymentTier::route('/{record}/edit'),
        ];
    }
}
