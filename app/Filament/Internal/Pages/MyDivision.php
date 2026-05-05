<?php

namespace App\Filament\Internal\Pages;

use App\Models\CommitteeAssignment;
use Filament\Pages\Page;

class MyDivision extends Page
{
    protected static string $view = 'filament.internal.pages.my-division';

    protected static ?string $navigationIcon  = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'My Division';
    protected static ?string $title           = 'My Division';
    protected static ?int    $navigationSort  = 3;

    public function getHeading(): string
    {
        return '';
    }

    protected function getViewData(): array
    {
        $me         = auth()->user();
        $assignment = $me->currentAssignment?->load(['division', 'eventPeriod']);

        if (! $assignment) {
            return [
                'assignment'  => null,
                'coordinator' => null,
                'members'     => collect(),
                'myId'        => $me->id,
            ];
        }

        $all = CommitteeAssignment::with(['user.wilayah'])
            ->where('event_period_id', $assignment->event_period_id)
            ->where('division_id', $assignment->division_id)
            ->where('is_active', true)
            ->get()
            ->sortBy(fn ($a) => $a->user->full_name);

        $coordinator = $all->firstWhere('position', 'coordinator');
        $members     = $all->filter(fn ($a) => $a->position !== 'coordinator')->values();

        return [
            'assignment'  => $assignment,
            'coordinator' => $coordinator,
            'members'     => $members,
            'myId'        => $me->id,
        ];
    }
}
