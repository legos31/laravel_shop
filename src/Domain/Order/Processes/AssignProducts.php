<?php

namespace Domain\Order\Processes;

use Domain\Order\Models\Order;

class AssignProducts implements \Domain\Order\Contracts\OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        $order->orderItems()
            ->createMany(
                cart()->items()->map(function ($item) {
                    return [
                        'product_id' => $item->product_id,
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                    ];
                })->toArray()
            );
        return $next($order);

    }
}
