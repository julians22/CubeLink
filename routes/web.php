<?php

use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LinkRedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'showDefault'])->name('landing.default');

Route::get('/l/{linkId}', LinkRedirectController::class)
    ->whereNumber('linkId')
    ->name('links.redirect');
