<?php

namespace App\Filament\Resources\ParticipantResource\Pages;

use App\Exports\ParticipantExport;
use App\Filament\Resources\ParticipantResource;
use App\Models\EventPeriod;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Maatwebsite\Excel\Facades\Excel;

class ListParticipants extends ListRecords
{
    protected static string $resource = ParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            Actions\Action::make('export')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->form([
                    \Filament\Forms\Components\Select::make('event_period_id')
                        ->label('Periode')
                        ->options(EventPeriod::orderByDesc('year')->pluck('year', 'id'))
                        ->default(fn () => EventPeriod::where('is_active', true)->first()?->id)
                        ->required()
                        ->native(false),
                ])
                ->action(function (array $data): \Symfony\Component\HttpFoundation\BinaryFileResponse {
                    $period   = EventPeriod::find($data['event_period_id']);
                    $filename = 'peserta-sks-' . ($period?->year ?? 'all') . '.xlsx';

                    return Excel::download(
                        new ParticipantExport($data['event_period_id']),
                        $filename
                    );
                }),
        ];
    }
}
