<?php

namespace Domain\Order\Processes;


use Domain\Order\Contracts\OrderProcessContract;

class CheckProductQuantity implements OrderProcessContract
{

    public function handle(\Domain\Order\Models\Order $order, $next)
    {
        foreach (cart()->items() as $item) {
            if ($item->product->quantity < $item->quantity) {
                throw new \DomainException('Not more quantity product');
            }
        }

        return $next($order);
    }
}
