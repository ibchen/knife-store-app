<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Добавляем EnsureFrontendRequestsAreStateful для работы с Sanctum в группе API
        $middleware->api([EnsureFrontendRequestsAreStateful::class]);
        $middleware->web([VerifyCsrfToken::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
