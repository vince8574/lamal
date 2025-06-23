<?php

namespace App\Providers;

use App\AnonymousUser;
use App\Facades\AnonymousUser as AnonymousUserFacade;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //

        $this->app->singleton(AnonymousUserFacade::class, function () {
            return new AnonymousUser;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Livewire::setPaginationView('pagination.tailwind');
    }
}
