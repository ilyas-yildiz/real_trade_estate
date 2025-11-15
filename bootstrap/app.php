<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware; // 'use' satırı zaten ekli

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) { // ':void' kaldırıldı
        
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'bayi'  => \App\Http\Middleware\BayiMiddleware::class,
        ]);

        $middleware->redirectUsersTo('/admin/dashboard');

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withProviders([
        \App\Providers\ViewServiceProvider::class,
    ])
    ->create();