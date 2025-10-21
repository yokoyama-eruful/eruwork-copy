<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__ . '/../routes/auth.php',
            __DIR__ . '/../routes/web.php',
        ],
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withBroadcasting(
        __DIR__ . '/../routes/channels.php',
        ['middleware' => [
            'web',
        ]],
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function () {
            return route('login');
        });
        $middleware->alias(include 'middleware.php');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
