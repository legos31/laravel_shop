<?php

namespace Domain\Order\States;

class CancelOrderState extends OrderState
{

    protected  array $allowedTransitions = [

    ];

    public function canBeChanged(): bool
    {
        return false;
    }

    public function value(): string
    {
        return 'cancelled';
    }

    public function humanValue(): bool
    {
        return 'Отменен';
    }
}
