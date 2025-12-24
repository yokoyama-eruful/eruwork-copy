<?php

declare(strict_types=1);

use App\Http\Controllers\Timecard\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'web',
])->group(function () {
    Route::prefix('public-timecard')->name('public-timecard.')->group(function () {

        Route::get('/login', [AuthController::class, 'index'])
            ->name('login');

        Route::post('/login', [AuthController::class, 'login'])
            ->name('login.post');
    });

});
