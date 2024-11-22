<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
                // Redirect unauthenticated users to the login page
                $middleware->redirectGuestsTo(fn (Request $request) => route('account.login'));

                // Redirect authenticated users to their profile
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

