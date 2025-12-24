<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Timecard\Http\Controllers\Punch\PunchController;

Route::middleware([
    'auth:timecard',
])->group(function () {
    Route::controller(PunchController::class)
        ->prefix('punch')
        ->name('punch.')
        ->group(function () {
            Route::get('', 'index')->name('index');
        });
});
