<?php

namespace Domain\Catalog\Models;

use Domain\Product\Models\Product;
use Domain\Catalog\Collections\CategoryCollection;
use Domain\Catalog\QueryBuilders\CategoryQueryBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'title', 'slug', 'on_home_page', 'sorting'
    ];

//    public function newCollection(array $models = [])
//    {
//        return new CategoryCollection($models);
//    }

    public function newEloquentBuilder($query): CategoryQueryBuilder
    {
        return new CategoryQueryBuilder($query);
    }

//    public function scopeHomePage (Builder $query) {
//        $query->where('on_home_page' , true)->orderBy('sorting')->limit(6);
//    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Category $category) {
            $category->slug = $category->slug ?? str($category->title)->slug;
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
