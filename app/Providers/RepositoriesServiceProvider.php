<?php

namespace App\Providers;

use App\Contracts\PrimesRepositoryContract;
use App\Repositories\PrimesRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(PrimesRepositoryContract::class, PrimesRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {}
}
