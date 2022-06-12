<?php

namespace Domain\User\Providers;

use Domain\User\Models\User;
use Domain\User\Repositories\Caches\UserCacheDecorator;
use Domain\User\Repositories\Contracts\UserRepositoryInterface;
use Domain\User\Repositories\UserRepository;
use Domain\User\Services\AuthService;
use Domain\User\Services\Contracts\AuthServiceInterface;
use Domain\User\Services\Contracts\UserServiceInterface;
use Domain\User\Services\UserService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::middleware('api')->group(function () {
            $this->loadRoutesFrom(__DIR__ . '/../Http/Routes/auth.php');
            $this->loadRoutesFrom(__DIR__ . '/../Http/Routes/user.php');
        });
    }

    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, function () {
            return new UserCacheDecorator(
                new UserRepository(new User)
            );
        });

        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }
}
