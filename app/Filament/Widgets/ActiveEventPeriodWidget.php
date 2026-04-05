<?php

namespace App\Filament\Widgets;

use App\Models\EventPeriod;
use Filament\Widgets\Widget;

class ActiveEventPeriodWidget extends Widget
{
    protected static string $view = 'filament.widgets.active-event-period-widget';
    protected static ?int $sort = -2;
    protected int | string | array $columnSpan = 1;

    public function getPeriod(): ?EventPeriod
    {
        return EventPeriod::where('is_active', true)->first();
    }
}
