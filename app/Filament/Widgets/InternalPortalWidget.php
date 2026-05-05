<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class InternalPortalWidget extends Widget
{
    protected static string $view = 'filament.widgets.internal-portal-widget';

    protected static ?int $sort = -1; // show at the top

    protected int | string | array $columnSpan = 'full';
}
