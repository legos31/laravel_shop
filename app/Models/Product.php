<?php

namespace App\Models;

use Support\Casts\PriceCast;
use Support\Traits\Models\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    protected $casts = [
        'price' => PriceCast::class
    ];
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'title', 'slug', 'brand_id', 'price', 'thumbnail' , 'on_home_page', 'sorting'
    ];

    public function scopeHomePage (Builder $query) {
        $query->where('on_home_page' , true)->orderBy('sorting')->limit(6);
    }

    public function brand() :BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category() :BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
