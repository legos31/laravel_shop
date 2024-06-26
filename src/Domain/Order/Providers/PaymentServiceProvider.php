<?php

namespace Domain\Order\Providers;

use Domain\Order\Payment\Gateways\YooKassa;
use Domain\Order\Payment\PaymentData;
use Domain\Order\Payment\PaymentSystem;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register()
    {


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        PaymentSystem::provider(new YooKassa());

        PaymentSystem::onCreating(function (PaymentData $data){
            return $data;
        });
    }
}

