<?php

namespace Domain\Order\Payment;

use Domain\Order\Contracts\PaymentGatewayContract;
use Domain\Order\Models\Payment;
use Domain\Order\Models\PaymentHistory;
use Domain\Order\States\Payment\CancelledPaymentState;
use Domain\Order\States\Payment\PaidPaymentState;
use Domain\Order\Traits\PaymentEvents;

class PaymentSystem
{
    use PaymentEvents;

    protected static PaymentGatewayContract $provider;

    public static function provider(PaymentGatewayContract|\Closure $provider): void
    {

        if(is_callable($provider)) {
            $provider = call_user_func($provider);
        }

        if(!$provider instanceof PaymentGatewayContract) {
            throw new \DomainException('Не верная функция провайдер платежного шлюза');
        }

        self::$provider = $provider;
    }

    public static function create(PaymentData $data): PaymentGatewayContract
    {
        if(!self::$provider instanceof PaymentGatewayContract) {
            throw new \DomainException('Не верная функция провайдер платежного шлюза');
        }
        Payment::query()->create([
            'payment_id' => $data->id,
        ]);

        if(is_callable(self::$onCreating))
        {
            $data = call_user_func(self::$onCreating, $data);
        }
        return self::$provider->data($data);
    }

    public static function validate(): PaymentGatewayContract
    {
        if(!self::$provider instanceof PaymentGatewayContract) {
            throw new \DomainException('Не верная функция провайдер платежного шлюза');
        }
        PaymentHistory::query()->create([
            'method' => request()->method(),
            'payload' => self::$provider->request(),
            'payment_gateway' => get_class(self::$provider),
        ]);

        if (self::$provider->validate() && self::$provider->paid()) {
            try {
                $payment = Payment::query()->where('payment_id', self::$provider->paymentId())
                ->firstOr(function () {
                    throw new \DomainException('Платеж не найден!');
                });

                if(is_callable(self::$onSuccess))
                {
                    call_user_func(self::$onSuccess, $payment);
                }

                $payment->state->transitionsTo(PaidPaymentState::class);

            } catch (\DomainException $e) {

                if(is_callable(self::$onError))
                {
                    call_user_func(self::$onError, self::$provider->errorMessage() ?? $e->getMessage());
                }

            }
        }
        return self::$provider;
    }
}
