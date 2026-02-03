<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\SettingController;

Route::middleware([
    'web',
    'auth',
    'can:register',
])->group(function () {
    Route::controller(SettingController::class)
        ->prefix('setting')
        ->name('setting.')
        ->group(function () {
            Route::get('', 'index')->name('index');
            Route::post('punch', 'updatePunchSetting')->name('punch.update');
            Route::post('pay_unit', 'updatePayUnitSetting')->name('pay_unit.update');
        });
});
