<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

/**
 * Файл конфигурации для приложения Laravel.
 *
 * Настраивает маршруты, промежуточное ПО (middleware) и обработку исключений.
 */
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',    // Маршруты для веб-приложения
        api: __DIR__ . '/../routes/api.php',    // Маршруты для API
        commands: __DIR__ . '/../routes/console.php', // Консольные команды
        health: '/up'   // URL для проверки работоспособности приложения
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Добавление EnsureFrontendRequestsAreStateful для работы Sanctum с API
        $middleware->api([EnsureFrontendRequestsAreStateful::class]);

        // Добавление VerifyCsrfToken для защиты от CSRF-атак
        $middleware->web([VerifyCsrfToken::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Вы можете добавить обработку исключений здесь
        // Например: $exceptions->map(Exception::class, CustomExceptionHandler::class);
    })
    ->create();
