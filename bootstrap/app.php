<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\WorkerMiddleware;
use App\Http\Middleware\ClientMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'worker' => WorkerMiddleware::class,
            'users' => ClientMiddleware::class,
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
