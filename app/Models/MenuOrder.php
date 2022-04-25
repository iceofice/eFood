<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuOrder extends Pivot
{
    use HasFactory;

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    public static function booted()
    {
        static::saved(function ($menuOrder) {
            static::calculateTotal($menuOrder);
        });

        static::deleted(function ($menuOrder) {
            static::calculateTotal($menuOrder);
        });
    }

    /**
     * Calculate the total of the order.
     *
     * @param  \App\Models\MenuOrder  $menuOrder
     * @return void
     */
    public static function calculateTotal(MenuOrder $menuOrder)
    {
        $order = Order::find($menuOrder->order_id);

        $total = $order->menus->reduce(function ($total, $item) {
            return $total + ($item->pivot->qty * $item->pivot->price);
        });
        $order->total = $total;
        $order->save();
    }
}
