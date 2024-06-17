<?php

namespace Domain\Order\States;

class NewOrderState extends OrderState
{

    protected  array $allowedTransitions = [
        PendingOrderState::class,
        CancelOrderState::class,
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return 'new';
    }

    public function humanValue(): bool
    {
        return 'Новый заказ';
    }
}
