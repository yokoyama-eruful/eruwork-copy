<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'web',
])->group(function () {
    Route::middleware('auth')->group(function () {
        Route::controller(DashboardController::class)
            ->prefix('dashboard')
            ->group(function (): void {
                Route::get('/', 'index')->name('dashboard');
            });
    });
});
