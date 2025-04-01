<?php

use App\Http\Middleware\CreateAnonymousUser;
use App\Http\Middleware\IdentifyAnonymousUser;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use KDA\Laravel\Locale\Middleware\LocaleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(IdentifyAnonymousUser::class);
        $middleware->web(CreateAnonymousUser::class);
        $middleware->web(LocaleMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
