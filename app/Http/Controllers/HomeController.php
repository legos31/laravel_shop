<?php

namespace App\Http\Controllers;

use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use App\Models\Product;
use Domain\Catalog\ViewModels\CategoryViewModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class HomeController
 * @package App\Http\Controllers
 * @method
 */
class HomeController extends Controller
{
    public function __invoke() :string|View
    {
        $categories = (new CategoryViewModel)->homePage();
        $products = Product::query()->homePage()->get();
        $brands = Brand::query()->homePage()->get();
        return view('index', compact('categories', 'products', 'brands'));
    }
}
