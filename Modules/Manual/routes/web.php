<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Manual\Http\Controllers\General\ManualFileController;
use Modules\Manual\Http\Controllers\General\ManualFolderController;
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
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::controller(ManualFolderController::class)
        ->name('manualFolder.')
        ->prefix('manualFolder')
        ->group(function () {
            Route::get('/', 'index')->name('index');
        });

    Route::controller(ManualFileController::class)
        ->name('manualFile.')
        ->prefix('manualFile')
        ->group(function () {
            Route::get('folder/{folder_id}', 'index')->name('index');
            Route::get('folder/{folder_id}/file/{file_id}', 'show')->name('show');
        });
});
