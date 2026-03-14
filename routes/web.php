<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PublicRegistrationForm;

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', function () {
    $activePeriod = \App\Models\EventPeriod::where('is_active', true)->first();
    return view('home', compact('activePeriod'));
})->name('home');
Route::get('/daftar', PublicRegistrationForm::class)->name('registration.form');
Route::get('/cek-status', \App\Livewire\CheckRegistrationStatus::class)->name('registration.status');

