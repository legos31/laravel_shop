<?php


namespace Domain\Catalog\ViewModels;


use Domain\Catalog\Models\Category;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class CategoryViewModel
{

    public function homePage()
    {
        return Cache::rememberForever('category_home_page', function () {
            return Category::query()->homePage()->get();
        }) ;
    }
}
