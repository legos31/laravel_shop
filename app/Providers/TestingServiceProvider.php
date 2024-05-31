<?php


namespace App\Providers;


use Support\Testing\FakerImageProvider;
use Faker\Factory;
use Faker\Generator;

class TestingServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Generator::class, function () {
            $faker = Factory::create();
            $faker->addProvider(new FakerImageProvider($faker));

            return $faker;
        });

    }

    public function boot() :void
    {

    }
}
