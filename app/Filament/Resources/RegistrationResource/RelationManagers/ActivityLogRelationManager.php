<?php

namespace App\Filament\Resources\RegistrationResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;

class ActivityLogRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';
    protected static ?string $title = 'Riwayat Perubahan';
    protected static ?string $icon = 'heroicon-o-clock';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Activity::query()
                    ->where('subject_type', \App\Models\Registration::class)
                    ->where('subject_id', $this->getOwnerRecord()->id)
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i')
                    ->width('140px'),

                Tables\Columns\TextColumn::make('causer.full_name')
                    ->label('Oleh')
                    ->default('— Sistem —'),

                Tables\Columns\BadgeColumn::make('description')
                    ->label('Aksi')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'created'  => 'Dibuat',
                        'updated'  => 'Diperbarui',
                        'deleted'  => 'Dihapus',
                        'restored' => 'Dipulihkan',
                        default    => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'created'  => 'success',
                        'updated'  => 'warning',
                        'deleted'  => 'danger',
                        'restored' => 'info',
                        default    => 'gray',
                    }),

                Tables\Columns\TextColumn::make('changes_count')
                    ->label('Field Berubah')
                    ->getStateUsing(fn (Activity $record) => $record->description === 'created'
                        ? count($record->attribute_changes?->get('attributes', []) ?? [])
                        : count($record->attribute_changes?->get('old', []) ?? [])
                    )
                    ->suffix(' field')
                    ->color('gray'),
            ])
            ->actions([
                Tables\Actions\Action::make('view_changes')
                    ->label('Detail')
                    ->icon('heroicon-o-magnifying-glass')
                    ->color('gray')
                    ->visible(fn (Activity $record) =>
                        ! empty($record->attribute_changes?->get(
                            $record->description === 'created' ? 'attributes' : 'old', []
                        ) ?? [])
                    )
                    ->modalHeading('Detail Perubahan')
                    ->modalContent(fn (Activity $record) => view(
                        'filament.activity-log.diff',
                        ['activity' => $record]
                    ))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup'),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25])
            ->headerActions([]);
    }
}
