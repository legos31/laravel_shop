<?php

namespace Domain\Product\Models;

use App\Jobs\ProductJsonProperties;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\QueryBuilders\ProductQueryBuilder;
use Illuminate\Pipeline\Pipeline;
use Support\Casts\PriceCast;
use Support\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{

    use HasSlug;
    use HasFactory;


    protected $casts = [
        'price' => PriceCast::class,
        'json_properties' => 'array'
    ];

    protected $fillable = [
        'title', 'slug', 'brand_id', 'price', 'thumbnail' , 'on_home_page',
        'sorting', 'text','json_properties', 'quantity'
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function (Product $product) {
            ProductJsonProperties::dispatch($product)
            ->delay(now()->addSeconds(20));
        });

    }

    public function newEloquentBuilder($query): ProductQueryBuilder
    {
        return new ProductQueryBuilder($query);
    }

    public function scopeFiltered(Builder $query)
    {
        return app(Pipeline::class)
            ->send($query)
            ->through(filters())
            ->thenReturn();

        //вариант 2
//        foreach (filters() as $filter) {
//            $query = $filter->apply($query);
//        }

        //вариант 1
//        $query->when(request('filters.brands'), function (Builder $b) {
//            $b->whereIn('brand_id', request('filters.brands'));
//        })->when(request('filters.price'), function (Builder $b) {
//            $b->whereBetween('price', [
//                request('filters.price.from',0) * 100,
//                request('filters.price.to',100000) * 100,
//            ]);
//        });
    }
//    public function scopeSorted(Builder $query)
//    {
//        $query->when(request('sort'), function (Builder $b) {
//           $column = request()->str('sort');
//           if ($column->contains(['price', 'title'])) {
//               $direction = $column->contains('-') ? 'DESC' : 'ASC';
//               $b->orderBy((string) $column->remove('-'), $direction);
//           }
//        });
//    }

//    public function scopeHomePage (Builder $query) {
//        $query->where('on_home_page' , true)->orderBy('sorting')->limit(6);
//    }

    public function brand() :BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category() :BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function makeThumbnail($size)
    {
        return $this->thumbnail;
    }

    public function down() :void
    {
        if (!app()->isProduction()) {
            Schema::table('{{ table }}', function (Blueprint $table) {

            });
        }
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)
            ->withPivot('value');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }

}
