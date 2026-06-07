<?php

namespace App\Filament\Pages;

use App\Models\EventClass;
use App\Models\EventPeriod;
use App\Models\Participant;
use App\Models\Team;
use App\Services\TeamAssignmentService;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class DistribusiKelompok extends Page implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    protected static string  $view            = 'filament.pages.distribusi-kelompok';
    protected static ?string $navigationIcon  = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Data Pendaftaran / Peserta';
    protected static ?string $navigationLabel = 'Distribusi Kelompok';
    protected static ?string $title           = 'Distribusi Kelompok';
    protected static ?int    $navigationSort  = 4;

    /** Currently selected class tab: 'kecil' | 'tengah' | 'besar' */
    public string $activeTab = 'kecil';

    /** Holds the participant ID being moved, used by pindahAction form options. */
    public ?int $pindahParticipantId = null;

    // ── Header actions ────────────────────────────────────────────────────────

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate')
                ->label('Generate Otomatis')
                ->icon('heroicon-o-bolt')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Generate Distribusi Kelompok')
                ->modalDescription(function (): string {
                    $period = EventPeriod::where('is_active', true)->first();
                    if (! $period) {
                        return 'Tidak ada periode aktif.';
                    }
                    $hasAssigned = Participant::where('event_period_id', $period->id)
                        ->whereNotNull('team_id')
                        ->exists();

                    return $hasAssigned
                        ? '⚠️ Beberapa peserta sudah memiliki kelompok. Proses ini akan MERESET semua assignment dan mendistribusikan ulang. Lanjutkan?'
                        : 'Distribusikan semua peserta ke kelompok secara otomatis berdasarkan constraints dan balancing gender/wilayah/kelas. Lanjutkan?';
                })
                ->modalSubmitActionLabel('Ya, Generate Sekarang')
                ->action(function (): void {
                    $period = EventPeriod::where('is_active', true)->first();
                    if (! $period) {
                        Notification::make()->title('Tidak ada periode aktif.')->danger()->send();
                        return;
                    }

                    $stats = (new TeamAssignmentService())->run($period);

                    $body = null;
                    if (! empty($stats['warnings'])) {
                        $body = implode("\n", $stats['warnings']);
                    }
                    if ($stats['skipped'] > 0) {
                        $body = ($body ? $body . "\n" : '') . "{$stats['skipped']} peserta dilewati (tidak ada tim untuk kelasnya).";
                    }

                    Notification::make()
                        ->title("✅ {$stats['assigned']} peserta berhasil didistribusikan!")
                        ->body($body)
                        ->success()
                        ->send();
                }),
        ];
    }

    // ── Pindah (move participant) action ──────────────────────────────────────

    public function pindahAction(): Action
    {
        return Action::make('pindah')
            ->label('Pindah')
            ->modalHeading('Pindah Peserta ke Tim Lain')
            ->modalWidth('md')
            ->mountUsing(function (Form $form, array $arguments): void {
                $this->pindahParticipantId = $arguments['id'] ?? null;

                $participant = Participant::find($this->pindahParticipantId);
                $form->fill(['team_id' => $participant?->team_id]);
            })
            ->form([
                Select::make('team_id')
                    ->label('Tim Tujuan')
                    ->native(false)
                    ->searchable()
                    ->required()
                    ->options(function (): array {
                        if (! $this->pindahParticipantId) {
                            return [];
                        }
                        $participant = Participant::find($this->pindahParticipantId);
                        if (! $participant) {
                            return [];
                        }

                        return Team::where('event_class_id', $participant->event_class_id)
                            ->orderBy('number')
                            ->withCount('participants')
                            ->get()
                            ->mapWithKeys(fn ($t) => [
                                $t->id => "{$t->name} ({$t->participants_count} peserta)",
                            ])
                            ->toArray();
                    }),
            ])
            ->action(function (array $data): void {
                if (! $this->pindahParticipantId) {
                    return;
                }

                Participant::where('id', $this->pindahParticipantId)
                    ->update(['team_id' => $data['team_id']]);

                Notification::make()
                    ->title('Peserta berhasil dipindahkan.')
                    ->success()
                    ->send();

                $this->pindahParticipantId = null;
            });
    }

    // ── View data ─────────────────────────────────────────────────────────────

    protected function getViewData(): array
    {
        $period = EventPeriod::where('is_active', true)->first();

        if (! $period) {
            return [
                'period'  => null,
                'stats'   => [],
                'classes' => [],
            ];
        }

        $eventClasses = EventClass::where('event_period_id', $period->id)
            ->orderBy('grade_min')
            ->get();

        // Map level → tab key
        $levelToTab = ['kecil' => 'kecil', 'tengah' => 'tengah', 'besar' => 'besar'];

        $classesData = [];
        foreach ($eventClasses as $eventClass) {
            $tab = $levelToTab[$eventClass->level] ?? $eventClass->level;

            $teams = Team::where('event_period_id', $period->id)
                ->where('event_class_id', $eventClass->id)
                ->orderBy('number')
                ->with(['participants.registration.wilayah'])
                ->get();

            // Target size: count ALL participants in this class (including unassigned)
            $totalInClass = Participant::where('event_period_id', $period->id)
                ->where('event_class_id', $eventClass->id)
                ->count();

            $teamCount = $teams->count();
            $base      = $teamCount > 0 ? intdiv($totalInClass, $teamCount) : 0;
            $extra     = $teamCount > 0 ? $totalInClass % $teamCount : 0;

            $teamsData = $teams->values()->map(function ($team, int $i) use ($base, $extra) {
                return [
                    'model'  => $team,
                    'target' => $base + ($i < $extra ? 1 : 0),
                    'count'  => $team->participants->count(),
                ];
            });

            $classesData[] = [
                'class'  => $eventClass,
                'tab'    => $tab,
                'label'  => 'Kelas ' . ucfirst($eventClass->level) . ' — ' . $eventClass->saint_name,
                'teams'  => $teamsData,
                'total'  => $totalInClass,
            ];
        }

        $totalParticipants = Participant::where('event_period_id', $period->id)->count();
        $assignedCount     = Participant::where('event_period_id', $period->id)
            ->whereNotNull('team_id')->count();

        return [
            'period'  => $period,
            'stats'   => [
                'total'      => $totalParticipants,
                'assigned'   => $assignedCount,
                'unassigned' => $totalParticipants - $assignedCount,
            ],
            'classes' => $classesData,
        ];
    }
}
