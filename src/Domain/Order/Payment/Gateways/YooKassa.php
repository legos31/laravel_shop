<?php

namespace Domain\Order\Payment\Gateways;

use Domain\Order\Contracts\PaymentGatewayContract;
use Domain\Order\Payment\PaymentData;
use Illuminate\Http\JsonResponse;

class YooKassa implements \Domain\Order\Contracts\PaymentGatewayContract
{

    public function paymentId(): string
    {
        // TODO: Implement paymentId() method.
    }

    public function configure(array $config): void
    {
        // TODO: Implement configure() method.
    }

    public function data(PaymentData $data): \Domain\Order\Contracts\PaymentGatewayContract
    {
        // TODO: Implement data() method.
    }

    public function request(): mixed
    {
        // TODO: Implement request() method.
    }

    public function responce(): JsonResponse
    {
        // TODO: Implement responce() method.
    }

    public function url(): string
    {
        // TODO: Implement url() method.
    }

    public function validate(): bool
    {
        // TODO: Implement validate() method.
    }

    public function paid(): bool
    {
        // TODO: Implement paid() method.
    }

    public function errorMessage(): string
    {
        // TODO: Implement errorMessage() method.
    }
}
