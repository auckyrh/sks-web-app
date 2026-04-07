<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Log Aktivitas';
    protected static ?string $navigationGroup = 'Sistem';
    protected static ?int $navigationSort = 99;
    protected static ?string $modelLabel = 'Log Aktivitas';
    protected static ?string $pluralModelLabel = 'Log Aktivitas';

    public static function canCreate(): bool { return false; }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Activity::query()->with('causer')->latest())
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Timestamp')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->width('140px'),

                Tables\Columns\TextColumn::make('causer.full_name')
                    ->label('Causer')
                    ->default('— Sistem —')
                    ->searchable()
                    ->width('140px'),

                Tables\Columns\BadgeColumn::make('log_name')
                    ->label('Model')
                    ->color('primary'),

                Tables\Columns\BadgeColumn::make('description')
                    ->label('Action')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'created' => 'created',
                        'updated' => 'updated',
                        'deleted' => 'deleted',
                        'restored' => 'restored',
                        default   => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'created'  => 'success',
                        'updated'  => 'warning',
                        'deleted'  => 'danger',
                        'restored' => 'info',
                        default    => 'gray',
                    }),

                Tables\Columns\TextColumn::make('subject_id')
                    ->label('ID Record')
                    ->width('80px'),

                Tables\Columns\TextColumn::make('changes_count')
                    ->label('Changes/Perubahan')
                    ->getStateUsing(fn (Activity $record) => $record->description === 'created'
                        ? count($record->attribute_changes?->get('attributes', []) ?? [])
                        : count($record->attribute_changes?->get('old', []) ?? [])
                    )
                    ->suffix(' field')
                    ->color('gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('log_name')
                    ->label('Model')
                    ->options(
                        Activity::query()
                            ->distinct('log_name')
                            ->pluck('log_name', 'log_name')
                            ->toArray()
                    ),
                Tables\Filters\SelectFilter::make('description')
                    ->label('Action')
                    ->options([
                        'created'  => 'created',
                        'updated'  => 'updated',
                        'deleted'  => 'deleted',
                        'restored' => 'restored',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')->label('from'),
                        \Filament\Forms\Components\DatePicker::make('until')->label('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('created_at', '<=', $data['until']));
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('view_changes')
                    ->label('Lihat Perubahan')
                    ->icon('heroicon-o-magnifying-glass')
                    ->color('gray')
                    ->visible(fn (Activity $record) =>
                        ! empty($record->attribute_changes?->get(
                            $record->description === 'created' ? 'attributes' : 'old', []
                        ) ?? [])
                    )
                    ->modalHeading(fn (Activity $record) =>
                        'Perubahan — ' . $record->log_name . ' #' . $record->subject_id
                    )
                    ->modalContent(fn (Activity $record) => view(
                        'filament.activity-log.diff',
                        ['activity' => $record]
                    ))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
            ])
            ->defaultSort('created_at', 'desc')
            ->defaultPaginationPageOption(25)
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }
}
