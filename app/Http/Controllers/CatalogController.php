<?php


namespace App\Http\Controllers;


use App\View\ViewModels\CatalogViewModel;
use Domain\Product\Models\Product;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;


class CatalogController extends Controller
{
    public function __invoke(?Category $category): View
    {
        return view('catalog.index', new CatalogViewModel($category));
    }
}
