<?php

namespace App\Filament\Widgets;

use App\Models\CommitteeAssignment;
use App\Models\Division;
use App\Models\EventPeriod;
use Filament\Widgets\Widget;

class CommitteeByDivisionWidget extends Widget
{
    protected static string $view = 'filament.widgets.committee-by-division-widget';
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 1;

    protected static $palette = [
        '#6366f1', '#8b5cf6', '#ec4899', '#f97316',
        '#f59e0b', '#10b981', '#14b8a6', '#3b82f6',
    ];

    public function getData(): array
    {
        $period = EventPeriod::where('is_active', true)->first();

        $counts = CommitteeAssignment::query()
            ->when($period, fn ($q) => $q->where('event_period_id', $period->id))
            ->selectRaw('division_id, COUNT(*) as total')
            ->groupBy('division_id')
            ->pluck('total', 'division_id');

        $divisions = Division::orderBy('name')->get();

        $rows = [];
        $i    = 0;
        foreach ($divisions as $division) {
            $total = $counts[$division->id] ?? 0;
            if ($total === 0) continue;

            $rows[] = [
                'name'  => $division->name,
                'count' => $total,
                'color' => self::$palette[$i % count(self::$palette)],
            ];
            $i++;
        }

        $max = $rows ? max(array_column($rows, 'count')) : 1;

        return ['rows' => $rows, 'max' => $max];
    }
}
