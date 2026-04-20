<?php

namespace App\Filament\Widgets;

use App\Models\CommitteeAssignment;
use App\Models\Division;
use App\Models\EventPeriod;
use Filament\Widgets\ChartWidget;

class CommitteeByDivisionWidget extends ChartWidget
{
    protected static ?string $heading = 'Komite per Divisi';
    protected static ?int $sort = 5;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $period = EventPeriod::where('is_active', true)->first();

        $counts = CommitteeAssignment::query()
            ->when($period, fn ($q) => $q->where('event_period_id', $period->id))
            ->selectRaw('division_id, COUNT(*) as total')
            ->groupBy('division_id')
            ->pluck('total', 'division_id');

        $divisions = Division::orderBy('name')->get();

        $labels = [];
        $data   = [];
        $colors = [];

        $palette = [
            '#6366f1', '#8b5cf6', '#ec4899', '#f97316',
            '#f59e0b', '#10b981', '#14b8a6', '#3b82f6',
        ];

        foreach ($divisions as $i => $division) {
            $total = $counts[$division->id] ?? 0;
            if ($total === 0) continue;

            $labels[] = $division->name;
            $data[]   = $total;
            $colors[] = $palette[$i % count($palette)];
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Anggota Komite',
                    'data'            => $data,
                    'backgroundColor' => $colors,
                    'borderRadius'    => 6,
                    'borderSkipped'   => false,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins'   => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'ticks'       => ['stepSize' => 1],
                    'grid'        => ['color' => 'rgba(0,0,0,0.05)'],
                ],
                'y' => [
                    'grid' => ['display' => false],
                ],
            ],
        ];
    }
}
