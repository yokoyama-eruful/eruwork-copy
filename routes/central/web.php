<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsoleController;
use App\Http\Controllers\TrashController;
use Illuminate\Support\Facades\Route;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->name('central.')
        ->group(function () {
            Route::controller(AuthController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::post('login', 'login')->name('login');
                    Route::post('logout', 'logout')->name('logout');
                });

            Route::middleware(['central'])
                ->group(function (): void {
                    Route::controller(ConsoleController::class)
                        ->group(function () {
                            Route::get('/home', 'index')->name('home');
                            Route::get('/create', 'create')->name('create');
                            Route::post('/store', 'store')->name('store');
                            Route::get('/edit/{id}', 'edit')->name('edit');
                            Route::post('/update/{id}', 'update')->name('update');
                            Route::delete('/destroy/{id}', 'delete')->name('delete');
                            Route::get('/show/{id}', 'show')->name('show');
                            Route::get('/search', 'search')->name('search');
                        });

                    Route::controller(TrashController::class)
                        ->name('trash.')
                        ->prefix('trash')
                        ->group(function () {
                            Route::get('/index', 'index')->name('index');
                            Route::post('/restore/{id}', 'restore')->name('restore');
                            Route::delete('/destroy/{id}', 'delete')->name('delete');
                            Route::get('/search', 'search')->name('search');
                        });
                });

        });
}
