<?php


namespace Domain\Cart\Providers;


use Domain\Cart\CartManager;
use Domain\Cart\Contracts\CartStorageContract;
use Domain\Cart\Storage\SessionStorage;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(provider: ActionServiceProvider::class);

        $this->app->bind(CartStorageContract::class, SessionStorage::class);
        $this->app->singleton(CartManager::class);

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
