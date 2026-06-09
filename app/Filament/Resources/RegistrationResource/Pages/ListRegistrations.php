<?php

namespace App\Filament\Resources\RegistrationResource\Pages;

use App\Exports\RegistrationExport;
use App\Filament\Resources\RegistrationResource;
use App\Models\EventClass;
use App\Models\EventPeriod;
use App\Models\Participant;
use App\Models\Registration;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ListRegistrations extends ListRecords
{
    protected static string $resource = RegistrationResource::class;

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
                    $period = EventPeriod::find($data['event_period_id']);
                    $filename = 'registrasi-sks-' . ($period?->year ?? 'all') . '.xlsx';

                    return Excel::download(
                        new RegistrationExport($data['event_period_id']),
                        $filename
                    );
                }),

            Actions\Action::make('bulk_generate_participants')
                ->label('Generate Semua Peserta')
                ->icon('heroicon-o-user-group')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Generate Semua Peserta')
                ->modalDescription(function (): string {
                    $period = EventPeriod::where('is_active', true)->first();

                    if (! $period) {
                        return 'Tidak ada periode aktif saat ini.';
                    }

                    $count = Registration::where('event_period_id', $period->id)
                        ->where('payment_status', 'verified')
                        ->whereDoesntHave('participant')
                        ->count();

                    $already = Registration::where('event_period_id', $period->id)
                        ->whereHas('participant')
                        ->count();

                    return "{$count} registrasi verified belum memiliki data peserta dan akan diproses."
                        . ($already > 0 ? " ({$already} sudah memiliki peserta dan akan dilewati.)" : '');
                })
                ->modalSubmitActionLabel('Generate Sekarang')
                ->action(function (): void {
                    $period = EventPeriod::where('is_active', true)->first();

                    if (! $period) {
                        Notification::make()
                            ->title('Tidak ada periode aktif.')
                            ->danger()
                            ->send();
                        return;
                    }

                    // Load EventClasses for this period once — used for auto-assigning class
                    $classes = EventClass::where('event_period_id', $period->id)->get();

                    $registrations = Registration::where('event_period_id', $period->id)
                        ->where('payment_status', 'verified')
                        ->whereDoesntHave('participant')
                        ->get();

                    if ($registrations->isEmpty()) {
                        Notification::make()
                            ->title('Semua registrasi verified sudah memiliki data peserta.')
                            ->info()
                            ->send();
                        return;
                    }

                    $created  = 0;
                    $noClass  = 0;

                    DB::transaction(function () use ($registrations, $classes, $period, &$created, &$noClass): void {
                        foreach ($registrations as $registration) {
                            // Auto-assign event_class_id by matching grade to EventClass range
                            $eventClass = $classes->first(
                                fn ($c) => $registration->grade >= $c->grade_min
                                    && $registration->grade <= $c->grade_max
                            );

                            if (! $eventClass) {
                                $noClass++;
                            }

                            Participant::create([
                                'registration_id' => $registration->id,
                                'event_period_id' => $period->id,
                                'event_class_id'  => $eventClass?->id,
                                'child_full_name' => $registration->child_full_name,
                                'nickname'        => $registration->nickname,
                                'gender'          => $registration->gender,
                                'birth_date'      => $registration->birth_date,
                                'grade'           => $registration->grade,
                                'parent_name'     => $registration->parent_name,
                                'parent_whatsapp' => $registration->parent_whatsapp,
                                'tshirt_size'     => $registration->tshirt_size,
                                'allergies'       => $registration->allergies,
                                'notes'           => $registration->notes,
                                'created_by'      => auth()->id(),
                            ]);

                            $created++;
                        }
                    });

                    $body = $noClass > 0
                        ? "{$noClass} peserta tidak cocok dengan kelas manapun — event_class_id kosong. Periksa grade_min/grade_max di Event Class."
                        : null;

                    Notification::make()
                        ->title("✅ {$created} peserta berhasil dibuat!")
                        ->body($body)
                        ->success()
                        ->send();
                }),
        ];
    }
}
