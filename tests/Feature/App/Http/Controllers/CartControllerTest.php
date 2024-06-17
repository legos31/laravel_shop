<?php


namespace App\Http\Controllers;


use Database\Factories\ProductFactory;
use Domain\Cart\CartManager;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        CartManager::fake();
    }

    /** @test */

    public function it_is_empty_cart(): void
    {
        cart()->truncate();
        $this->get(action([CartController::class, 'index']))
        ->assertOk()
        ->assertViewIs('cart.index');
        //->assertViewHas('items', collect([]));
    }

    /** @test */
    public function it_is_not_empty_cart(): void
    {
        $product = ProductFactory::new()->create();
        cart()->add($product);
        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('items', cart()->items());
    }

    /** @test */
    public function it_added_success(): void
    {
        //cart()->truncate();
        $this->assertEquals(1, cart()->count());
        $product = ProductFactory::new()->create();
        $this->post(
            action([CartController::class, 'add'], $product));
        $this->assertEquals(2, cart()->count());
    }

    /** @test */
    public function it_added_quantity(): void
    {
        $product = ProductFactory::new()->create();
        cart()->add($product ,4);
        $this->assertEquals(6, cart()->count());

        $this->post(
            action([CartController::class, 'quantity'], cart()->items()->first(), ['quantity' => 5]));
        $this->assertEquals(6, cart()->count());
    }


    public function it_delete(): void
    {
        $product = ProductFactory::new()->create();
        cart()->add($product ,3);
        $this->assertEquals(9, cart()->count());

        $this->delete(
            action([CartController::class, 'delete'], cart()->items()->first()));
        $this->assertEquals(0, cart()->count());
    }

    /** @test */
    public function it_truncate(): void
    {
        $product = ProductFactory::new()->create();
        cart()->add($product ,3);
        $this->assertEquals(9, cart()->count());

        $this->delete(
            action([CartController::class, 'truncate']));
        $this->assertEquals(0, cart()->count());
    }

}
