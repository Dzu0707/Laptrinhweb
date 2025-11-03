<?php

use Illuminate\Support\Facades\Route;

// Đây là file route API, hiện tạm để trống.
Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});
