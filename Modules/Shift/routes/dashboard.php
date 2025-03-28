<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Shift\Http\Controllers\Admin\ShiftManagerController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    'can:register',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::controller(ShiftManagerController::class)
        ->prefix('shiftManager')
        ->name('shiftManager.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::get('{manager}', 'show')->name('show');
            Route::delete('{manager}', 'destroy')->name('destroy');
        });
});
