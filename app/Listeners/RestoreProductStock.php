<?php

namespace App\Listeners;

use App\Models\Product;
use App\Events\OrderCancelled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RestoreProductStock
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCancelled $event): void
    {
        $order_items = $event->order->items;
        foreach ($order_items as $item) {
            $product = Product::find($item->product_id);
            $product->stock += $item->quantity;
            $product->save();
        }
        $event->order->update(['status' => 'cancelled']);
    }
}
