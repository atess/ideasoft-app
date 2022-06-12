<?php

use Domain\Order\Http\Controllers\OrderController;
use Domain\Order\Http\Controllers\OrderDiscountController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('orders', OrderController::class)->except('update');
    Route::get('orders/{order_id}/discounts', [OrderDiscountController::class, 'show'])->name('orders.discounts');
});
