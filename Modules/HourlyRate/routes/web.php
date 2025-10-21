<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\HourlyRate\Http\Controllers\HourlyRateController;

Route::middleware([
    'web',
    'auth',
])->group(function () {
    Route::controller(HourlyRateController::class)->group(function () {
        Route::get('hourlyRate', 'index')->name('hourlyRate.index');
        Route::get('hourlyRate/{id}', 'show')->name('hourlyRate.show');
    });
});
