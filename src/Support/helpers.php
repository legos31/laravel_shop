<?php

use Domain\Catalog\Filters\FilterManagar;
use Support\Flash\Flash;

if (!function_exists('flash')) {
    function flash () : Flash
    {
        return app(Flash::class);
    }
}

if (!function_exists('filters')) {
    function filters () :array
    {
        return app(FilterManagar::class)->items();
    }
}

if (!function_exists('is_catalog_view')) {
    function is_catalog_view (string $type, string $default = 'grid') :bool
    {
        return session('view', $default) === $type ;
    }
}


if (!function_exists('filter_url')) {
    function filter_url (?\Domain\Catalog\Models\Category $category, array $params = []) :string
    {
        return route('catalog', [
           ...request()->only(['filters', 'sort']),
           ...$params,
           'category' => $category
        ]);
    }
}
if (!function_exists('cart')) {
    function cart () :\Domain\Cart\CartManager
    {
        return app(\Domain\Cart\CartManager::class);
    }
}

