<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Manual\Http\Controllers\General\ManualFileController;
use Modules\Manual\Http\Controllers\General\ManualFolderController;

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

            Route::get('/thumbnail/{id}', 'thumbnail')->name('thumbnail');
            Route::get('/movie/{id}', 'movie')->name('movie');
            Route::get('/detail/{id}', 'detail')->name('detail');
            Route::get('/step/{id}/{index}', 'step')->name('step');
        });

});
