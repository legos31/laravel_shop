<?php


namespace App\Filters;


use Domain\Catalog\Filters\AbstractFilter;
use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Builder;

class BrandFilter extends AbstractFilter
{

    public function title(): string
    {
        return 'Бренды';
    }

    public function key(): string
    {
        return 'brands';
    }

    public function apply(Builder $query): Builder
    {

        return $query->when($this->requestValue(), function (Builder $b) {
            //dd($this->requestValue());
            $b->whereIn('brand_id', $this->requestValue());
        });
    }

    public function values(): array
    {
        return $brands = Brand::query()->select('id', 'title')->has('products')->get()->pluck('title', 'id')->toArray();
    }

    public function view(): string
    {
        return 'catalog.filters.brands';
    }
}
