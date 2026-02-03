<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Board\Http\Controllers\BoardController;
use Modules\Board\Http\Controllers\DraftController;

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
    'auth',
])->group(function () {
    Route::group([], function () {
        Route::controller(BoardController::class)
            ->prefix('board')
            ->name('board.')
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::get('/{id}', 'show')->name('show');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::delete('/{id}', 'destroy')->name('destroy');
                Route::get('/{id}/download', 'download')->name('download');
            });

        Route::resource('draft', DraftController::class)
            ->only(['index'])
            ->names('draft');
    });
});
