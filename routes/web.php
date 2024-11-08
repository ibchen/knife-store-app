<?php

use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\PlatformScreen;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', PlatformScreen::class)->name('platform.dashboard');
});
