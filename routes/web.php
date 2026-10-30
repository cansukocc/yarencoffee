<?php

use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::post('/iletisim', [ContactMessageController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('contact.store');
