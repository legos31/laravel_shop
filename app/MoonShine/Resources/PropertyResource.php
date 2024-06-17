<?php

namespace App\MoonShine\Resources;

use Domain\Product\Models\Property;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Actions\FiltersAction;

class PropertyResource extends Resource
{
	public static string $model = Property::class;

	public static string $title = 'Properties';

	public function fields(): array
	{
		return [
		    ID::make()->sortable(),
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
        return [];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}
