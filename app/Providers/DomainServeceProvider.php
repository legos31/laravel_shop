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
        $this->app->register(\Domain\Product\Providers\ProductServiceProvider::class);
        $this->app->register(\Domain\Cart\Providers\CartServiceProvider::class);
        $this->app->register(\Domain\Order\Providers\OrderServiceProvider::class);
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
