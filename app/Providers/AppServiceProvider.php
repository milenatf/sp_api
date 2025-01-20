<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repository\EmailVerification\{
    EmailVerificationRepositoryInterface,
    EmailVerificationEloquentORM
};
use App\Repository\Post\{
    PostEloquentORM,
    PostRepositoryInterface
};

use App\Repository\User\{
    UserRepositoryInterface,
    UserEloquentORM
};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            EmailVerificationRepositoryInterface::class,
            EmailVerificationEloquentORM::class
        );

        $this->app->bind(
            PostRepositoryInterface::class,
            PostEloquentORM::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserEloquentORM::class
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
