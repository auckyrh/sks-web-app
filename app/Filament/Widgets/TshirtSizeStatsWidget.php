<?php

namespace App\Filament\Widgets;

use App\Models\CommitteeAssignment;
use App\Models\EventPeriod;
use App\Models\TshirtSize;
use Filament\Widgets\Widget;

class TshirtSizeStatsWidget extends Widget
{
    protected static string $view = 'filament.widgets.tshirt-size-stats-widget';

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $period = EventPeriod::where('is_active', true)->first();

        if (! $period) {
            return ['rows' => collect(), 'total' => 0, 'unsetCount' => 0, 'periodYear' => null];
        }

        $assignments = CommitteeAssignment::where('event_period_id', $period->id)->get();
        $total       = $assignments->count();
        $unsetCount  = $assignments->whereNull('tshirt_size_id')->count();

        $sizes = TshirtSize::where('event_period_id', $period->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $countById = $assignments->whereNotNull('tshirt_size_id')
            ->groupBy('tshirt_size_id')
            ->map->count();

        $rows = $sizes->map(fn ($s) => [
            'label'   => $s->label,
            'count'   => $countById[$s->id] ?? 0,
            'percent' => $total > 0 ? round(($countById[$s->id] ?? 0) / $total * 100) : 0,
        ])->filter(fn ($r) => $r['count'] > 0);

        return [
            'rows'       => $rows,
            'total'      => $total,
            'unsetCount' => $unsetCount,
            'periodYear' => $period->year,
        ];
    }
}
