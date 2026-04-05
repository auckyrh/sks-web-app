<?php

namespace App\Filament\Widgets;

use App\Models\EventPeriod;
use App\Models\Registration;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RegistrationsChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Pendaftaran per Hari';
    protected static ?int $sort = 2;
    protected static ?string $maxHeight = '280px';

    public ?string $filter = '30';

    protected function getFilters(): ?array
    {
        return [
            '7'  => '7 hari terakhir',
            '14' => '14 hari terakhir',
            '30' => '30 hari terakhir',
        ];
    }

    protected function getData(): array
    {
        $period = EventPeriod::where('is_active', true)->first();

        $days = (int) ($this->filter ?? 30);
        $start = now()->subDays($days - 1)->startOfDay();

        $query = Registration::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', $start)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        if ($period) {
            $query = Registration::where('event_period_id', $period->id)
                ->where('created_at', '>=', $start)
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('count', 'date');
        }

        // Fill all days with 0 so the chart has no gaps
        $labels = [];
        $data   = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date     = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->translatedFormat('d M');
            $data[]   = (int) ($query[$date] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Pendaftar baru',
                    'data'            => $data,
                    'fill'            => true,
                    'backgroundColor' => 'rgba(245, 158, 11, 0.12)',
                    'borderColor'     => 'rgb(245, 158, 11)',
                    'borderWidth'     => 2,
                    'tension'         => 0.4,
                    'pointBackgroundColor' => 'rgb(245, 158, 11)',
                    'pointRadius'     => 3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
