<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\HourlyRate\Http\Controllers\HourlyRateController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    'auth',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::resource('hourlyRate', HourlyRateController::class)->names('hourlyRate');
});
