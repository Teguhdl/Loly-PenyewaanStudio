<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Users\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\UserRepository;

use App\Domain\Categories\Repositories\CategoryRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\CategoryRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }
}
