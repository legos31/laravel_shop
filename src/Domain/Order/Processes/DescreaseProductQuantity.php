<?php

namespace Domain\Order\Processes;

use Domain\Order\Models\Order;
use Illuminate\Support\Facades\DB;

class DescreaseProductQuantity implements \Domain\Order\Contracts\OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        foreach (cart()->items() as $item)
        {
            $item->product()->update([
                'quantity' => DB::raw('quantity -' .$item->quantity)
            ]);
        }
        return $next($order);
    }
}
