<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Timecard\Http\Controllers\General\TimecardController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::resource('timecard', TimecardController::class)->names('timecard');
});
