<?php

declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebPushController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

require __DIR__ . '/dashboard.php';

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/', function () {
            return view('home.index');
        })->name('home');

        Route::controller(WebPushController::class)
            ->prefix('webPush')
            ->name('webPush')
            ->group(function (): void {
                Route::get('/', 'index');
                Route::post('subscribe', 'subscribe')->name('subscribe');
                Route::post('unsubscribe', 'unsubscribe')->name('subscribe');
                Route::get('welcomeMessage', 'send')->name('welcomeMessage');
            });

        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile', 'edit')->name('profile.edit');
            Route::post('/profile', 'update')->name('profile.update');
            Route::delete('/profile', 'destroy')->name('profile.destroy');
        });
    });
});
