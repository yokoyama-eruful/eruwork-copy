<?php

declare(strict_types=1);

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});
