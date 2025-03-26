<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Timecard\Http\Controllers\Admin\WorkTimeController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware([
    'web',
    'can:register',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    // Route::resource('shiftManager', ShiftManagerController::class)->names('manager');

    Route::controller(WorkTimeController::class)
        ->prefix('timecardManager')
        ->name('timecardManager.')
        ->group(function () {
            Route::get('', 'index')->name('index');
        });
});
