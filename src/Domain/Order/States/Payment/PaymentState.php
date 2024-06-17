<?php

namespace Domain\Order\States\Payment;

use Spatie\ModelStates\StateConfig;

abstract class PaymentState extends \Spatie\ModelStates\State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(PendingPaymentState::class)
            ->allowAllTransitions(PendingPaymentState::class, PaidPaymentState::class)
            ->allowAllTransitions(PendingPaymentState::class, CancelledPaymentState::class);
    }
}
