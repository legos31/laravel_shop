<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use Domain\Product\Models\Product;

use MoonShine\Decorations\Tab;
use MoonShine\Fields\BelongsTo;
use MoonShine\Fields\BelongsToMany;
use MoonShine\Fields\Image;
use MoonShine\Fields\Text;
use MoonShine\Filters\BelongsToFilter;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class ProductResource extends Resource
{
	public static string $model = Product::class;

	public static string $title = 'Products';
    public static array $with = [
        'category', 'properties'
    ];

	public function fields(): array
	{
		return [


                ID::make()->sortable(),
                Text::make('Title')->showOnExport(),
                BelongsTo::make(label: 'Brand', resource: 'title'),
                Text::make('Price'),
                Image::make('Thumbnail')->dir('images/product')->withPrefix('/storage/'),

                BelongsToMany::make('Category', resource: 'title')->hideOnIndex(),

                BelongsToMany::make('Properties', resource: 'title')->fields([
                    Text::make('Value'),
                ])->hideOnIndex(),

                BelongsToMany::make('OptionValues', resource: 'title')->fields([
                    Text::make('Value'),
                ])->hideOnIndex(),

        ];
	}

	public function rules(Model $item): array
	{
	    return [];
    }

    public function search(): array
    {
        return ['id'];
    }

    public function filters(): array
    {
        return [
            BelongsToFilter::make('Brand', resource: 'title')->searchable()
        ];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
