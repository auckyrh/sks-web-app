<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PublicEvaluationForm;
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

    $upcomingTierData = $upcomingTier ? [
        'name'       => $upcomingTier->name,
        'valid_from' => $upcomingTier->valid_from->locale('id')->isoFormat('D MMM Y'),
        'valid_until'=> $upcomingTier->valid_until->locale('id')->isoFormat('D MMM Y'),
    ] : null;

    // Skip the "are you paroki member?" SWAL when there is no upcoming tier,
    // meaning all tiers (including Umum) are already open — everyone can register directly.
    $skipParokiCheck = $upcomingTier === null;

    $registrationClosed = session()->pull('registration_closed', false);

    return view('home', compact('activePeriod', 'activeTier', 'upcomingTier', 'upcomingTierData', 'skipParokiCheck', 'registrationClosed'));
})->name('home');
Route::get('/daftar', PublicRegistrationForm::class)->name('registration.form');
Route::get('/cek-status', \App\Livewire\CheckRegistrationStatus::class)->name('registration.status');
Route::get('/{year}/rundown', \App\Livewire\PublicPage::class)->name('public.rundown');
Route::get('/{year}/tata-tertib', \App\Livewire\PublicPage::class)->name('public.tata-tertib');
Route::get('/{year}/informasi', \App\Livewire\PublicPage::class)->name('public.informasi');
Route::get('/{year}/kontak', \App\Livewire\PublicKontak::class)->name('public.kontak');
Route::get('/{year}/kelompok', \App\Livewire\PublicKelompok::class)->name('public.kelompok');
Route::get('/evaluasi', PublicEvaluationForm::class)->name('evaluation.form');

// Friendly login redirect — panitia can go to /login instead of /admin/login
Route::redirect('/login', '/internal/login')->name('login');
