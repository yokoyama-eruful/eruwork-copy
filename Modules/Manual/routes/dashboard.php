<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Manual\Http\Controllers\Admin\ManualFileManagerController;
use Modules\Manual\Http\Controllers\Admin\ManualFolderManagerController;
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
    Route::controller(ManualFolderManagerController::class)
        ->name('manualFolderManager.')
        ->prefix('manualFolderManager')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{folder_id}/edit', 'edit')->name('edit');
            Route::put('/{folder_id}', 'update')->name('update');
            Route::delete('/{folder_id}', 'destroy')->name('destroy');
        });

    Route::controller(ManualFileManagerController::class)
        ->name('manualFileManager.')
        ->prefix('manualFileManager')
        ->group(function () {
            Route::get('/{folder_id}/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{folder_id}', 'index')->name('index');
            Route::get('/{file_id}/edit', 'edit')->name('edit');
            Route::put('/{file_id}', 'update')->name('update');
            Route::delete('/{file_id}', 'destroy')->name('destroy');
        });
});
