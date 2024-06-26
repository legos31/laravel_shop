<?php


namespace App\Http\Controllers;


use Database\Factories\Domain\Catalog\Models\BrandFactory;
use Database\Factories\Domain\Catalog\Models\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    //use RefreshDatabase;
    /** @test */
    public function it_success_responce()
    {
        ProductFactory::new()->count(5)->create([
            'on_home_page' => true,
            'sorting' => 999
        ]);

        $product = ProductFactory::new()->createOne([
            'on_home_page' => true,
            'sorting' => 1
        ]);

        CategoryFactory::new()->count(5)->create([
            'on_home_page' => true,
            'sorting' => 999
        ]);

        $category = CategoryFactory::new()->createOne([
            'on_home_page' => true,
            'sorting' => 1
        ]);

        BrandFactory::new()->count(5)->create([
            'on_home_page' => true,
            'sorting' => 999
        ]);

        $brand = BrandFactory::new()->createOne([
            'on_home_page' => true,
            'sorting' => 1
        ]);

        $this->get(route('home'))->assertOk()
            ->assertViewHas('categories.0', $category)
            ->assertViewHas('products.0', $product)
            ->assertViewHas('brands.0', $brand);

    }
}
