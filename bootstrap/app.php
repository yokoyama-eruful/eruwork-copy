<?php

declare(strict_types=1);

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/central/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withBroadcasting(
        __DIR__ . '/../routes/channels.php',
        ['middleware' => [
            'web',
            InitializeTenancyByDomain::class,
            PreventAccessFromCentralDomains::class,
            'universal',
        ]],
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function () {
            return route('login');
        });
        $middleware->group('universal', []);
        $middleware->alias(include 'middleware.php');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
