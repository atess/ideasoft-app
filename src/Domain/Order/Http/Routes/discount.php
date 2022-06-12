<?php

use Domain\Order\Http\Controllers\DiscountController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::apiResources([
        'discounts' => DiscountController::class,
    ]);
});
