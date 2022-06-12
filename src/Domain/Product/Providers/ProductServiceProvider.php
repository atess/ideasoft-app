<?php

namespace Domain\Product\Providers;

use Domain\Product\Contracts\Repositories\CategoryRepositoryInterface;
use Domain\Product\Contracts\Repositories\ProductRepositoryInterface;
use Domain\Product\Contracts\Services\CategoryServiceInterface;
use Domain\Product\Contracts\Services\ProductServiceInterface;
use Domain\Product\Models\Category;
use Domain\Product\Models\Product;
use Domain\Product\Repositories\Caches\CategoryCacheDecorator;
use Domain\Product\Repositories\Caches\ProductCacheDecorator;
use Domain\Product\Repositories\CategoryRepository;
use Domain\Product\Repositories\ProductRepository;
use Domain\Product\Services\CategoryService;
use Domain\Product\Services\ProductService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, function () {
            return new ProductCacheDecorator(
                new ProductRepository(new Product)
            );
        });
        $this->app->bind(ProductServiceInterface::class, ProductService::class);

        $this->app->bind(CategoryRepositoryInterface::class, function () {
            return new CategoryCacheDecorator(
                new CategoryRepository(new Category)
            );
        });
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        Route::middleware('api')->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/../Http/Routes/product.php');
            $this->loadRoutesFrom(__DIR__ . '/../Http/Routes/category.php');
        });
    }
}
