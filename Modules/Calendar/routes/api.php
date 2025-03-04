<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Calendar\Http\Controllers\ScheduleController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('schedules', [ScheduleController::class, 'index']);
    Route::post('drag-schedule/{id}', [ScheduleController::class, 'updateDate']);
    Route::post('resize-schedule/{id}', [ScheduleController::class, 'updateTime']);
});
