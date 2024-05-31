<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DomainServeceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Domain\Auth\Providers\AuthServiceProvider::class);
        $this->app->register(\Domain\Catalog\Providers\CatalogServiceProvider::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
