<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PublicRegistrationForm;

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', function () {
    $activePeriod = \App\Models\EventPeriod::where('is_active', true)->first();

    $activeTier   = null;
    $upcomingTier = null;

    if ($activePeriod) {
        $activeTier = \App\Models\PaymentTier::where('event_period_id', $activePeriod->id)
            ->whereDate('valid_from', '<=', now())
            ->whereDate('valid_until', '>=', now())
            ->orderBy('valid_from')
            ->first();

        $upcomingTier = \App\Models\PaymentTier::where('event_period_id', $activePeriod->id)
            ->whereDate('valid_from', '>', now())
            ->orderBy('valid_from')
            ->first();
    }

    return view('home', compact('activePeriod', 'activeTier', 'upcomingTier'));
})->name('home');
Route::get('/daftar', PublicRegistrationForm::class)->name('registration.form');
Route::get('/cek-status', \App\Livewire\CheckRegistrationStatus::class)->name('registration.status');

