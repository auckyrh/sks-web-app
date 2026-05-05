<?php

namespace App\Filament\Internal\Pages;

use App\Models\EventPeriod;
use App\Models\TshirtSize;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Dashboard extends Page implements HasActions, HasForms
{
    use InteractsWithActions, InteractsWithForms;

    protected static string $view = 'filament.internal.pages.dashboard';

    protected static ?string $navigationIcon  = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title           = 'Dashboard';
    protected static ?int    $navigationSort  = 1;

    public function getHeading(): string
    {
        return '';
    }

    protected function getViewData(): array
    {
        $user = auth()->user()->load([
            'currentAssignment.division',
            'currentAssignment.tshirtSize',
            'currentAssignment.eventPeriod',
            'wilayah',
        ]);

        $assignment = $user->currentAssignment;

        $hour     = (int) now('Asia/Jakarta')->format('H');
        $greeting = match(true) {
            $hour >= 4  && $hour < 11 => 'Selamat Pagi',
            $hour >= 11 && $hour < 15 => 'Selamat Siang',
            $hour >= 15 && $hour < 18 => 'Selamat Sore',
            default                   => 'Selamat Malam',
        };

        $activePeriod = EventPeriod::where('is_active', true)->first();

        $daysLeft = null;
        if ($activePeriod?->event_start_date) {
            $daysLeft = (int) now('Asia/Jakarta')->startOfDay()
                ->diffInDays($activePeriod->event_start_date->startOfDay(), false);
        }

        return [
            'user'         => $user,
            'assignment'   => $assignment,
            'greeting'     => $greeting,
            'isAdmin'      => $user->isAdmin() || $user->isSuperAdmin(),
            'activePeriod' => $activePeriod,
            'daysLeft'     => $daysLeft,
        ];
    }

    public function editTshirtSizeAction(): Action
    {
        $assignment   = auth()->user()->currentAssignment;
        $activePeriod = EventPeriod::where('is_active', true)->first();

        $sizeOptions = $activePeriod
            ? TshirtSize::where('event_period_id', $activePeriod->id)
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->mapWithKeys(fn ($s) => [
                    $s->id => "{$s->label}  —  P {$s->panjang} × L {$s->lebar} cm",
                ])
                ->toArray()
            : [];

        return Action::make('editTshirtSize')
            ->label('Edit')
            ->icon('heroicon-s-pencil-square')
            ->size(\Filament\Support\Enums\ActionSize::ExtraSmall)
            ->outlined()
            ->color('warning')
            ->extraAttributes(['style' => 'padding: 0.1rem 0.4rem; font-size: 0.65rem; line-height: 1.2;'])
            ->modalHeading('Update T-shirt Size')
            ->modalDescription('Choose the size that fits you best.')
            ->modalSubmitActionLabel('Save')
            ->modalCancelActionLabel('Cancel')
            ->modalWidth('sm')
            ->fillForm(fn () => [
                'tshirt_size_id' => $assignment?->tshirt_size_id,
            ])
            ->form([
                Forms\Components\Select::make('tshirt_size_id')
                    ->label('T-shirt Size')
                    ->options($sizeOptions)
                    ->nullable()
                    ->placeholder('— Select a size —')
                    ->searchable(false),
            ])
            ->action(function (array $data) use ($assignment) {
                if (! $assignment) {
                    Notification::make()
                        ->title('No active assignment found')
                        ->warning()
                        ->send();
                    return;
                }

                $assignment->update(['tshirt_size_id' => $data['tshirt_size_id']]);

                Notification::make()
                    ->title('T-shirt size updated')
                    ->success()
                    ->send();
            });
    }
}
