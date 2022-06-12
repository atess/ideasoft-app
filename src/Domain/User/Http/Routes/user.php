<?php

use Domain\User\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::apiResources([
        'users' => UserController::class,
    ]);
});
