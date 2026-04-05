<?php

namespace App\Filament\Widgets;

use App\Models\EventPeriod;
use App\Models\Registration;
use App\Models\Wilayah;
use Filament\Widgets\ChartWidget;

class RegistrationsByWilayahWidget extends ChartWidget
{
    protected static ?string $heading = 'Pendaftaran per Wilayah';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $period = EventPeriod::where('is_active', true)->first();

        $counts = Registration::query()
            ->when($period, fn ($q) => $q->where('event_period_id', $period->id))
            ->whereNotNull('wilayah_id')
            ->selectRaw('wilayah_id, COUNT(*) as total')
            ->groupBy('wilayah_id')
            ->pluck('total', 'wilayah_id');

        $wilayahs = Wilayah::orderBy('name')->get();

        $labels = [];
        $data   = [];
        $colors = [];

        $palette = [
            '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6',
            '#ec4899', '#14b8a6', '#f97316', '#6366f1',
            '#84cc16', '#06b6d4',
        ];

        foreach ($wilayahs as $i => $wilayah) {
            $total = $counts[$wilayah->id] ?? 0;
            if ($total === 0) continue;

            $labels[] = $wilayah->name;
            $data[]   = $total;
            $colors[] = $palette[$i % count($palette)];
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Pendaftar',
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
