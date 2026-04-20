<?php

namespace App\Filament\Widgets;

use App\Models\Registration;
use App\Filament\Resources\RegistrationResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestRegistrationsWidget extends BaseWidget
{
    protected static ?string $heading = 'Pendaftaran Terbaru';
    protected static ?int $sort = 6;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Registration::query()
                    ->with(['wilayah', 'lingkungan', 'paymentTier'])
                    ->whereHas('eventPeriod', fn ($q) => $q->where('is_active', true))
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('registration_number')
                    ->label('No. Daftar')
                    ->badge()
                    ->color('gray')
                    ->searchable(),

                Tables\Columns\TextColumn::make('child_full_name')
                    ->label('Nama Anak')
                    ->searchable()
                    ->weight('semibold'),

                Tables\Columns\TextColumn::make('lingkungan.name')
                    ->label('Lingkungan')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('grade')
                    ->label('Kelas')
                    ->placeholder('—'),

                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('Status Bayar')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending'  => 'Menunggu',
                        'verified' => 'Terverifikasi',
                        'rejected' => 'Ditolak',
                        default    => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'pending'  => 'warning',
                        'verified' => 'success',
                        'rejected' => 'danger',
                        default    => 'gray',
                    }),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending'   => 'Pending',
                        'confirmed' => 'Dikonfirmasi',
                        'cancelled' => 'Dibatalkan',
                        default     => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'pending'   => 'gray',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        default     => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Didaftarkan')
                    ->since()
                    ->color('gray'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Registration $record) => RegistrationResource::getUrl('edit', ['record' => $record]))
                    ->openUrlInNewTab(),
            ])
            ->paginated(false);
    }
}
