<?php

use Domain\User\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'guest',
])->group(function () {
    Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
});

Route::middleware([
    'auth:api',
])->group(function () {
    Route::delete('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('auth/me', [AuthController::class, 'me'])->name('auth.me');
});
