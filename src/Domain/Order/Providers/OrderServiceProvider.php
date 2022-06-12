<?php

namespace Domain\Order\Providers;

use Domain\Order\Contracts\Repositories\DiscountRepositoryInterface;
use Domain\Order\Contracts\Repositories\OrderRepositoryInterface;
use Domain\Order\Contracts\Services\DiscountServiceInterface;
use Domain\Order\Contracts\Services\OrderServiceInterface;
use Domain\Order\Models\Discount;
use Domain\Order\Models\Order;
use Domain\Order\Repositories\Caches\DiscountCacheDecorator;
use Domain\Order\Repositories\Caches\OrderCacheDecorator;
use Domain\Order\Repositories\DiscountRepository;
use Domain\Order\Repositories\OrderRepository;
use Domain\Order\Services\DiscountService;
use Domain\Order\Services\OrderService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(OrderRepositoryInterface::class, function () {
            return new OrderCacheDecorator(
                new OrderRepository(new Order)
            );
        });
        $this->app->bind(OrderServiceInterface::class, OrderService::class);

        $this->app->bind(DiscountRepositoryInterface::class, function () {
            return new DiscountCacheDecorator(
                new DiscountRepository(new Discount)
            );
        });
        $this->app->bind(DiscountServiceInterface::class, DiscountService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Route::middleware('api')->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/../Http/Routes/order.php');
            $this->loadRoutesFrom(__DIR__ . '/../Http/Routes/discount.php');
        });
    }
}
