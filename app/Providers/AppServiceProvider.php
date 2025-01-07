<?php

namespace App\Providers;

use App\AnonymousUser;
use App\Facades\AnonymousUser as AnonymousUserFacade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //

        $this->app->singleton(AnonymousUserFacade::class, function () {
            return new AnonymousUser();
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
