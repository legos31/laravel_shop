<?php


namespace App\Http\Controllers;


use Database\Factories\ProductFactory;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /** @test */
    public function it_success_responce()
    {
        $product = ProductFactory::new()->create();
        $this->get(route('product', $product))->assertOk();
    }


}
