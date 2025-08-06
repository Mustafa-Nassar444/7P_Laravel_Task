<?php

namespace App\Traits;

use App\Models\Product;

trait OrderTrait
{
    public function get_product_data($request, $order)
    {
        $data = [];
        if ($request->products && is_array($request->products)) {
            foreach ($request->products as $item) {
                $product = Product::find($item['id']);
                if ($product->stock < $item['quantity']) {
                    return [
                        'status' => false,
                        'message' => 'Product stock is not enough',
                    ];
                }
                $data[] = [
                    'order_id' => $order,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ];
            }
        }
        return [
            'status' => true,
            'data' => $data,
        ];
    }
}
