<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware; // YENİ EKLENDİ

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        home: '/admin/dashboard'
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // YENİ EKLENDİ: 'admin' kısayolunu AdminMiddleware'e bağlıyoruz
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'bayi'  => \App\Http\Middleware\BayiMiddleware::class,
            // 'adminer' => \Onecentlin\Adminer\Http\Middleware\Authenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->withProviders([
        \App\Providers\ViewServiceProvider::class,
    ])->create();