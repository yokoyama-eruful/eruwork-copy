<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

require __DIR__ . '/..' . '/tenant/auth.php';

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {});
}
