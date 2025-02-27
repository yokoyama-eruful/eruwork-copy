<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::middleware('auth')->group(function () {
        Route::controller(DashboardController::class)
            ->prefix('dashboard')
            ->group(function (): void {
                Route::get('/', 'index')->name('dashboard');
            });
    });
});
