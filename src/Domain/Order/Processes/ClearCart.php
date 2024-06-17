<?php

namespace Domain\Order\Processes;

use Domain\Order\Models\Order;

class ClearCart implements \Domain\Order\Contracts\OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        cart()->truncate();
        return $next($order);
    }
}
