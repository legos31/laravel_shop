<?php


namespace Domain\Product\QueryBuilders;


use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pipeline\Pipeline;

class ProductQueryBuilder extends Builder
{
    public function homePage () {
        return $this->where('on_home_page' , true)->orderBy('sorting')->limit(6);
    }

    public function sorted(): ProductQueryBuilder
    {
        return $this->when(request('sort'), function (Builder $b) {
            $column = request()->str('sort');
            if ($column->contains(['price', 'title'])) {
                $direction = $column->contains('-') ? 'DESC' : 'ASC';
                $b->orderBy((string) $column->remove('-'), $direction);
            }
        });
    }
    public function filtered(): Builder|ProductQueryBuilder
    {
        return app(Pipeline::class)
            ->send($this)
            ->through(filters())
            ->thenReturn();
    }

    public function withCategory(Category $category): ProductQueryBuilder
    {
        return $this->when($category->exists, function (Builder $query) use ($category) {
                $query->whereRelation('category', 'categories.id', '=', $category->id);
            });
    }

    public function search(): ProductQueryBuilder
    {
        return $this->when(request('s'), function (Builder $query) {
            $query->whereFullText(['title', 'text'], request('s'));
        });
    }

}
