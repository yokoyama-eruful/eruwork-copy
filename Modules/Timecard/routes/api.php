<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Timecard\Http\Controllers\AttendanceController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('attendances', [AttendanceController::class, 'index']);
    Route::post('drag-attendance/{id}', [AttendanceController::class, 'updateDate']);
    Route::post('resize-attendance/{id}', [AttendanceController::class, 'updateTime']);
});
