<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Shift\Http\Controllers\General\ScheduleController;
use Modules\Shift\Http\Controllers\General\ShiftController;
use Modules\Shift\Http\Controllers\General\SubmissionController;

Route::middleware([
    'web',
    'auth',
])->group(function () {
    // Route::resource('shift', ShiftController::class)->names('shift');

    Route::controller(SubmissionController::class)
        ->prefix('shift/submission')
        ->name('shift.submission.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{manager}', 'show')->name('show');
        });

    // Route::get('shift/submission/{manager}', SubmissionController::class)->name('shift.submission');

    Route::get('shift/schedule', [ScheduleController::class, 'index'])->name('shift.schedule');
});
