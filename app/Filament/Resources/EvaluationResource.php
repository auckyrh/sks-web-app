<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EvaluationResource\Pages;
use App\Models\Division;
use App\Models\Evaluation;
use App\Models\EventClass;
use App\Models\EventPeriod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EvaluationResource extends Resource
{
    protected static ?string $model = Evaluation::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationGroup = 'Event Management';
    protected static ?string $navigationLabel = "Event's Evaluation Form";
    protected static ?string $modelLabel = 'Evaluasi';
    protected static ?string $pluralModelLabel = 'Evaluasi';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['eventPeriod', 'eventClass', 'details.division']))
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable(),
                Tables\Columns\TextColumn::make('respondent_type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'orang_tua' => 'Orang Tua',
                        'panitia' => 'Panitia',
                        default => $state,
                    })
                    ->color(fn (string $state) => match ($state) {
                        'orang_tua' => 'info',
                        'panitia' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('eventClass.saint_name')
                    ->label('Kelas')
                    ->placeholder('—')
                    ->sortable(),
                Tables\Columns\TextColumn::make('respondent_name')
                    ->label('Nama')
                    ->placeholder('Anonim')
                    ->searchable(),
                Tables\Columns\TextColumn::make('respondent_phone')
                    ->label('No. HP')
                    ->placeholder('—')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('details_count')
                    ->label('Jumlah Evaluasi')
                    ->counts('details')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                Tables\Columns\TextColumn::make('details.division.name')
                    ->label('Divisi Tujuan')
                    ->badge()
                    ->color('gray')
                    ->separator(', '),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Waktu Submit')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('submitted_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('event_period_id')
                    ->label('Tahun')
                    ->relationship('eventPeriod', 'year')
                    ->default(fn () => EventPeriod::where('is_active', true)->first()?->id),
                Tables\Filters\SelectFilter::make('respondent_type')
                    ->label('Tipe Responden')
                    ->options([
                        'orang_tua' => 'Orang Tua',
                        'panitia' => 'Panitia',
                    ]),
                Tables\Filters\SelectFilter::make('event_class_id')
                    ->label('Kelas')
                    ->options(fn () => EventClass::where('event_period_id', EventPeriod::where('is_active', true)->first()?->id)
                        ->orderBy('grade_min')
                        ->pluck('saint_name', 'id')),
                Tables\Filters\SelectFilter::make('division')
                    ->label('Divisi Tujuan')
                    ->options(fn () => Division::orderBy('name')->pluck('name', 'id'))
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['value'],
                        fn (Builder $q, $divisionId) => $q->whereHas('details', fn (Builder $dq) => $dq->where('division_id', $divisionId))
                    )),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        $eventPeriodId = EventPeriod::where('is_active', true)->first()?->id;

                        return \Maatwebsite\Excel\Facades\Excel::download(
                            new \App\Exports\EvaluationExport($eventPeriodId),
                            'Evaluasi-SKS-' . now()->format('Y-m-d') . '.xlsx'
                        );
                    }),
            ])
            ->defaultPaginationPageOption(25);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Data Responden')
                    ->schema([
                        Infolists\Components\TextEntry::make('respondent_type')
                            ->label('Tipe Responden')
                            ->badge()
                            ->formatStateUsing(fn (string $state) => match ($state) {
                                'orang_tua' => 'Orang Tua',
                                'panitia' => 'Panitia',
                                default => $state,
                            })
                            ->color(fn (string $state) => match ($state) {
                                'orang_tua' => 'info',
                                'panitia' => 'warning',
                                default => 'gray',
                            }),
                        Infolists\Components\TextEntry::make('eventClass.saint_name')
                            ->label('Kelas')
                            ->placeholder('—'),
                        Infolists\Components\TextEntry::make('respondent_name')
                            ->label('Nama')
                            ->placeholder('Anonim'),
                        Infolists\Components\TextEntry::make('respondent_phone')
                            ->label('No. HP')
                            ->placeholder('—'),
                        Infolists\Components\TextEntry::make('submitted_at')
                            ->label('Waktu Submit')
                            ->dateTime('d M Y, H:i'),
                    ])->columns(3),

                Infolists\Components\Section::make('Kesan & Pesan')
                    ->schema([
                        Infolists\Components\TextEntry::make('impressions')
                            ->label('')
                            ->placeholder('Tidak diisi')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Infolists\Components\RepeatableEntry::make('details')
                    ->label('Detail Evaluasi')
                    ->schema([
                        Infolists\Components\TextEntry::make('division.name')
                            ->label('Divisi')
                            ->badge()
                            ->color('warning'),
                        Infolists\Components\TextEntry::make('feedback')
                            ->label('Evaluasi / Kritik')
                            ->columnSpanFull(),
                        Infolists\Components\TextEntry::make('suggestions')
                            ->label('Saran')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvaluations::route('/'),
            'view' => Pages\ViewEvaluation::route('/{record}'),
        ];
    }
}
