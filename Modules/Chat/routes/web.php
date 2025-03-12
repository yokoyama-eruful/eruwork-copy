<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Chat\Http\Controllers\ChatController;
use Modules\Chat\Http\Controllers\ImageController;
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
    'auth',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::prefix('chat')
        ->name('chat.')
        ->group(function () {
            Route::get('image', [ImageController::class, 'show'])->name('image.show');

            Route::controller(ChatController::class)
                ->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('{group}', 'show')->name('show');
                });
        });
});
