<?php

declare(strict_types=1);

use App\Http\Middleware\CentalAuthMiddleware;

return [
    'central' => CentalAuthMiddleware::class,
];
