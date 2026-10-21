<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Dialihkan ke /tmp saat berjalan di Vercel
if (isset($_ENV['VERCEL_REGION'])) {
    $app = Application::configure(basePath: dirname(__DIR__))
        ->useStoragePath('/tmp/storage')
        ->withRouting(
            web: __DIR__.'/../routes/web.php',
            commands: __DIR__.'/../routes/console.php',
            health: '/up',
        )
        ->withMiddleware(function (Middleware $middleware) {
            //
        })
        ->withExceptions(function (Exceptions $exceptions) {
            //
        })->create();
} else {
    $app = Application::configure(basePath: dirname(__DIR__))
        ->useStoragePath(dirname(__DIR__).'/storage')
        ->withRouting(
            web: __DIR__.'/../routes/web.php',
            commands: __DIR__.'/../routes/console.php',
            health: '/up',
        )
        ->withMiddleware(function (Middleware $middleware) {
            //
        })
        ->withExceptions(function (Exceptions $exceptions) {
            //
        })->create();
}

return $app;