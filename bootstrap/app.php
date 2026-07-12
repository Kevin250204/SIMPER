<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // REGISTER ALIAS MIDDLEWARE
        $middleware->alias([
            'auth.check' => \App\Http\Middleware\AuthCheck::class,
        ]);

    })
    ->withExceptions(function ($exceptions) {
        //
    })

    ->withMiddleware(function ($middleware) {
        $middleware->alias([
            'auth.session' => \App\Http\Middleware\AuthSession::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })

    ->create();