<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Shift\Http\Controllers\Admin\ShiftManagerController;

Route::middleware([
    'web',
    'can:register',
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
