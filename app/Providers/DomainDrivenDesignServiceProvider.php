<?php

namespace App\Providers;

use Domain\Order\Providers\OrderServiceProvider;
use Domain\Product\Providers\ProductServiceProvider;
use Domain\User\Providers\UserServiceProvider;
use Illuminate\Support\ServiceProvider;
use Support\OrderHelper;

class DomainDrivenDesignServiceProvider extends ServiceProvider
{
    protected array $providers = [
        UserServiceProvider::class,
        ProductServiceProvider::class,
        OrderServiceProvider::class,
    ];

    public function register(): void
    {
        $this->registerProviders();

        $this->app->singleton('orderHelper', function () {
            return new OrderHelper();
        });
    }

    protected function registerProviders(): void
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }
}
