<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Timecard\Http\Controllers\Admin\AttendanceController;
use Modules\Timecard\Http\Controllers\Admin\TimecardController;

Route::middleware([
    'web',
    'can:register',
])->group(function () {
    Route::controller(AttendanceController::class)
        ->prefix('attendanceManager')
        ->name('attendanceManager.')
        ->group(function () {
            Route::get('', 'index')->name('index');
        });

    Route::controller(TimecardController::class)
        ->prefix('timecardManager')
        ->name('timecardManager.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('show/{id}', 'show')->name('show');
        });
});
