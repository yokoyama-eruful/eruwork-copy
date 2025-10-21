<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebPushController;
use Illuminate\Support\Facades\Route;

// require __DIR__ . '/dashboard.php';

Route::middleware([
    'web',
])->group(function () {
    Route::middleware('auth')->group(function () {
        Route::controller(HomeController::class)
            ->prefix('home')
            ->name('home.')
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
            });

        Route::controller(ProfileController::class)
            ->prefix('profile')
            ->name('profile.')
            ->group(function (): void {
                Route::get('/icon/{id}', 'icon')->name('icon');
            });

        // Route::get('/', function () {
        //     return view('home.index');
        // })->name('home');

        Route::controller(WebPushController::class)
            ->prefix('webPush')
            ->name('webPush')
            ->group(function (): void {
                Route::get('/', 'index');
                Route::post('subscribe', 'subscribe')->name('subscribe');
                Route::post('unsubscribe', 'unsubscribe')->name('unsubscribe');
                Route::get('welcomeMessage', 'send')->name('welcomeMessage');
            });

        Route::controller(ProfileController::class)->group(function () {
            Route::get('/profile', 'edit')->name('profile.edit');
            Route::post('/profile', 'update')->name('profile.update');
            Route::delete('/profile', 'destroy')->name('profile.destroy');
        });
    });
});
