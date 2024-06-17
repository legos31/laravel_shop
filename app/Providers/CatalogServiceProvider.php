<?php

namespace App\Providers;

use App\Filters\BrandFilter;
use App\Filters\PriceFilter;
use Domain\Catalog\Filters\FilterManagar;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(FilterManagar::class);
    }


    public function boot()
    {
        app(FilterManagar::class)->registerFilters([
            new PriceFilter(),
            new BrandFilter(),
        ]);
    }
}
