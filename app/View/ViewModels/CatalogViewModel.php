<?php

namespace App\View\ViewModels;

use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\ViewModels\ViewModel;
use Symfony\Component\HttpFoundation\Response;

class CatalogViewModel extends ViewModel
{
    public function __construct(
        public Category $category
    )
    {
        //
    }

    public function products(): LengthAwarePaginator
    {
        return Product::query()
            ->select('id', 'title','slug', 'thumbnail', 'price', 'json_properties')
            ->search()
            ->withCategory($this->category)
            ->filtered()
            ->sorted()
            ->paginate(6);
    }

    public function categories(): Collection|array
    {
        return Category::query()->select('id', 'title','slug')->has('products')->get();
    }
}
