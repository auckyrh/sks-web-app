<?php

namespace App\Providers;

use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentColor::register([
            // Override defaults
            'primary' => Color::Blue,
            'warning' => Color::Amber,
            'success' => Color::Green,
            'danger'  => Color::Red,
            'info'    => Color::Sky,
            'gray'    => Color::Zinc,

            // Extra colors for gathering types & badges
            'indigo'  => Color::Indigo,
            'violet'  => Color::Violet,
            'sky'     => Color::Sky,
            'teal'    => Color::Teal,
            'orange'  => Color::Orange,
            'rose'    => Color::Rose,
        ]);
    }
}
