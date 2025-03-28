<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Shift\Http\Controllers\General\ScheduleController;
use Modules\Shift\Http\Controllers\General\ShiftController;
use Modules\Shift\Http\Controllers\General\SubmissionController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    'auth',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::resource('shift', ShiftController::class)->names('shift');

    Route::get('submission/{manager}', SubmissionController::class)->name('submission.show');

    Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index');
});
