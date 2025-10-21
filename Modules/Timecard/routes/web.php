<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Timecard\Http\Controllers\General\TimecardController;

Route::middleware([
    'web',
])->group(function () {
    Route::controller(TimecardController::class)
        ->prefix('timecard')
        ->name('timecard.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('show/{date}', 'show')->name('show');
        });
});
