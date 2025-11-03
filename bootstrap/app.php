<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Alias middleware tùy chỉnh
    $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);
        // Nếu cần, bạn có thể thêm $middleware->web([...]) hoặc $middleware->api([...]) ở đây.
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // cấu hình xử lý exception nếu cần
    })
    ->create();
