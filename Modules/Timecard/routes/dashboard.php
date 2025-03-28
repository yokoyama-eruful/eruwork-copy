<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Timecard\Http\Controllers\Admin\WorkTimeController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    'can:register',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::controller(WorkTimeController::class)
        ->prefix('timecardManager')
        ->name('timecardManager.')
        ->group(function () {
            Route::get('', 'index')->name('index');
        });
});
