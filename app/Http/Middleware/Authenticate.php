<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Auth\AuthenticationException;

class Authenticate extends Middleware
{
    /**
     * Khi chưa đăng nhập thì Laravel sẽ gọi phương thức này.
     * Ta tắt hành vi redirect mặc định đi.
     */
    protected function redirectTo($request): ?string
    {
        if ($request->is('admin') || $request->is('admin/*')) {
            // ❌ Tắt redirect cho admin
            return null;
        }

        // Người dùng bình thường vẫn redirect
        return route('login');
    }
}
