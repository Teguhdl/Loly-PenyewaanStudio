<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Users\Repositories\UserRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\UserRepository;

use App\Domain\Categories\Repositories\CategoryRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\CategoryRepository;

use App\Domain\VirtualWorlds\Repositories\VirtualWorldRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\VirtualWorldRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(VirtualWorldRepositoryInterface::class, VirtualWorldRepository::class);

    }
}
