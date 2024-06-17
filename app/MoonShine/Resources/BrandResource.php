<?php

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use Domain\Catalog\Models\Brand;

use MoonShine\Actions\ExportAction;
use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Filters\TextFilter;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\Text;

class BrandResource extends Resource
{
	public static string $model = Brand::class;

	public static string $title = 'Brands';
    //public string $titleField = 'title';

	public function fields(): array
	{
		return [
		    ID::make()->sortable(),
            Text::make('Title')->showOnExport(),
            Image::make('Thumbnail')->dir('/'),

            SwitchBoolean::make('On home page'),
            Number::make('Sorting')->min(0)->max(10000),
        ];
	}

	public function rules(Model $item): array
	{
	    return [];
    }

    public function search(): array
    {
        return ['id', 'title'];
    }

    public function filters(): array
    {
        return [
            TextFilter::make('Title'),
        ];
    }

    public function actions(): array
    {
        return [
            ExportAction::make('Export'),
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
