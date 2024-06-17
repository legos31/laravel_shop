<?php


namespace Domain\Catalog\ViewModels;


use Domain\Catalog\Models\Brand;
use Illuminate\Support\Facades\Cache;

class BrandViewModel
{
    public function homePage()
    {
        return Cache::rememberForever('brand_home_page', function () {
            return Brand::query()->homePage()->get();
        }) ;
    }

}
