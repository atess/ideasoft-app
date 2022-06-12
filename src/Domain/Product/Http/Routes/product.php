<?php

use Domain\Product\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::apiResources([
        'products' => ProductController::class,
    ]);
});
