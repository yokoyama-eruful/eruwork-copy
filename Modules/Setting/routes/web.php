<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\SettingController;

Route::middleware([
    'web',
    'auth',
])->group(function () {
    Route::controller(SettingController::class)
        ->prefix('setting')
        ->name('setting.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::post('update', 'update')->name('update');
        });
});
