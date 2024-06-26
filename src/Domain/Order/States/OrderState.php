<?php

namespace Domain\Order\States;

use Domain\Order\Events\OrderStatusChanged;
use Domain\Order\Models\Order;
use http\Exception\InvalidArgumentException;

abstract class OrderState
{
    protected array $allowedTransitions = [

    ];
    public function __construct(protected Order $order)
    {
    }

    abstract public function canBeChanged(): bool;

    abstract public function humanValue(): bool;


    abstract public function value(): string;

    public function transitionTo(OrderState $state): void
    {
        if (!$this->canBeChanged()) {
            throw new InvalidArgumentException('Status can not be changed!');
        }

        if(!in_array(get_class($state), $this->allowedTransitions))
        {
            throw new InvalidArgumentException("No transitions for {$this->order->status->value()} to {$state}");
        }

        $this->order->updateQuietly([
            'status' => $state->value()
        ]);

        event(new OrderStatusChanged($this->order, $this->order->status, $state));

    }

}
