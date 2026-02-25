<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
    $middleware->alias([
        'superuser' => \App\Http\Middleware\Superuser::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (MethodNotAllowedHttpException $e) {
        abort(404);
    });
        })->create();
