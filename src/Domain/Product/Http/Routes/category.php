<?php

use Domain\Product\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::apiResources([
        'categories' => CategoryController::class,
    ]);
});
