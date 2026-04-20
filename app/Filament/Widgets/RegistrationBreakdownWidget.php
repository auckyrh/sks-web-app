<?php

namespace App\Filament\Widgets;

use App\Models\EventPeriod;
use App\Models\Registration;
use Filament\Widgets\Widget;

class RegistrationBreakdownWidget extends Widget
{
    protected static string $view = 'filament.widgets.registration-breakdown-widget';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function getData(): array
    {
        $period = EventPeriod::where('is_active', true)->first();

        if (! $period) {
            return ['grades' => [], 'sizes' => []];
        }

        $gradeOptions = [
            1 => 'Kelas 1',
            2 => 'Kelas 2',
            3 => 'Kelas 3',
            4 => 'Kelas 4',
            5 => 'Kelas 5',
            6 => 'Kelas 6',
        ];

        $sizeOptions = [
            'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL',
            'M-Dewasa', 'L-Dewasa', 'XL-Dewasa',
            '2XL-Dewasa', '3XL-Dewasa', '4XL-Dewasa', '5XL-Dewasa',
        ];

        $gradeCounts = Registration::where('event_period_id', $period->id)
            ->selectRaw('grade, COUNT(*) as total')
            ->groupBy('grade')
            ->pluck('total', 'grade');

        $sizeCounts = Registration::where('event_period_id', $period->id)
            ->selectRaw('tshirt_size, COUNT(*) as total')
            ->groupBy('tshirt_size')
            ->pluck('total', 'tshirt_size');

        $grades = [];
        foreach ($gradeOptions as $value => $label) {
            $grades[] = ['label' => $label, 'count' => $gradeCounts[$value] ?? 0];
        }

        $sizes = [];
        foreach ($sizeOptions as $size) {
            $count = $sizeCounts[$size] ?? 0;
            if ($count > 0) {
                $sizes[] = ['label' => $size, 'count' => $count];
            }
        }

        return ['grades' => $grades, 'sizes' => $sizes];
    }
}
