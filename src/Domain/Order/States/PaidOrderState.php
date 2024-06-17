<?php

namespace Domain\Order\States;

class PaidOrderState extends OrderState
{

    protected  array $allowedTransitions = [
        CancelOrderState::class,
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return 'paid';
    }

    public function humanValue(): bool
    {
        return 'Оплачен';
    }
}
