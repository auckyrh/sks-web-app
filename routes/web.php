<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\PublicRegistrationForm;

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', fn() => redirect('/daftar'));
Route::get('/daftar', PublicRegistrationForm::class)->name('registration.form');
Route::get('/cek-status', \App\Livewire\CheckRegistrationStatus::class)->name('registration.status');

