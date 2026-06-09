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
            'S-Dewasa', 'M-Dewasa', 'L-Dewasa', 'XL-Dewasa',
            '2XL-Dewasa', '3XL-Dewasa', '4XL-Dewasa', '5XL-Dewasa',
        ];

        // Grade × gender breakdown in one query
        $gradeGenderRows = Registration::where('event_period_id', $period->id)
            ->selectRaw('grade, gender, COUNT(*) as total')
            ->groupBy('grade', 'gender')
            ->get();

        // Index: [grade][gender] => count
        $gg = [];
        foreach ($gradeGenderRows as $row) {
            $gg[$row->grade][$row->gender] = (int) $row->total;
        }

        $grades = [];
        $totalF = 0;
        $totalM = 0;
        foreach ($gradeOptions as $value => $label) {
            $f = $gg[$value]['F'] ?? 0;
            $m = $gg[$value]['M'] ?? 0;
            $grades[] = ['label' => $label, 'count' => $f + $m, 'f' => $f, 'm' => $m];
            $totalF += $f;
            $totalM += $m;
        }

        $sizeCounts = Registration::where('event_period_id', $period->id)
            ->selectRaw('tshirt_size, COUNT(*) as total')
            ->groupBy('tshirt_size')
            ->pluck('total', 'tshirt_size');

        $sizes = [];
        foreach ($sizeOptions as $size) {
            $count = $sizeCounts[$size] ?? 0;
            if ($count > 0) {
                $sizes[] = ['label' => $size, 'count' => $count];
            }
        }

        return [
            'grades' => $grades,
            'sizes'  => $sizes,
            'totalF' => $totalF,
            'totalM' => $totalM,
        ];
    }
}
