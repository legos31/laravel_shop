<?php


namespace App\Job;


use App\Jobs\ProductJsonProperties;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ProductJsonPropertiesTest extends TestCase
{
    /** @test */
    public function it_created_json_properties()
    {
        $queue = Queue::getFacadeRoot();
        Queue::fake([ProductJsonProperties::class]);

        $properties = PropertyFactory::new()->count(10)->create();

        $product = ProductFactory::new()
            ->hasAttached($properties, function () {
                return ['value' => fake()->word()];
            })
            ->create();

        $this->assertEmpty($product->json_properties);

        Queue::swap($queue);
        ProductJsonProperties::dispatchSync($product);

        $product->refresh();

        $this->assertNotEmpty($product->json_properties);
    }
}
