<?php

namespace Database\Seeders;


use Database\Factories\Domain\Catalog\Models\CategoryFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Domain\Product\Models\Product;
use Domain\Product\Models\Option;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run() :void
    {

        Brand::factory(20)->create();
        OptionFactory::new()->count(2)->create();
        $optionValue = OptionValueFactory::new()->count(10)->create();
        $properties = PropertyFactory::new()->count(10)->create();
        CategoryFactory::new()->count(4)
            ->has(ProductFactory::new()->count(50)
                ->hasAttached($optionValue)
                ->hasAttached($properties, function (){
                return ['value' => ucfirst(fake()->word())];
            }))
            ->create();

    }
}
