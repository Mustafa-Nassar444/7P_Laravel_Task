<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Traits\OrderTrait;
use App\Events\OrderCreated;
use App\Events\OrderCancelled;
use App\Http\Resources\OrderResource;
use App\Http\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response;

class OrderService
{
    use OrderTrait;

    /**
     * Create a new order
     */
    public function create_order($request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();
            $data['status'] = 'pending';

            $order = Order::create($data);
            $product_data = $this->get_product_data($request, $order->id);

            if (!$product_data['status']) {
                return ResponseService::responseError(
                    $product_data['message'],
                    Response::HTTP_BAD_REQUEST
                );
            }

            OrderItem::insert($product_data['data']);
            event(new OrderCreated($product_data['data']));

            DB::commit();

            return ResponseService::responseSuccess(
                new OrderResource($order),
                'Order created successfully',
                Response::HTTP_CREATED
            );

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed: ' . $e->getMessage());
            return ResponseService::responseError(
                'Failed to create order',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Get order by ID with items
     */
    public function get_order($id)
    {
        $order = Order::with('items.product')->find($id);

        if (!$order) {
            return ResponseService::responseError(
                'Order not found',
                Response::HTTP_NOT_FOUND
            );
        }

        return ResponseService::responseSuccess(
            new OrderResource($order)
        );
    }

    /**
     * Update order status
     */
    public function update_order($request, $id)
    {
        DB::beginTransaction();
        try {
            $order = Order::find($id);

            if (!$order) {
                return ResponseService::responseError(
                    'Order not found',
                    Response::HTTP_NOT_FOUND
                );
            }

            $data = $request->validated();
            $order->update($data);

            if ($data['status'] === 'cancelled' && $order->status !== 'cancelled') {
                event(new OrderCancelled($order));
            }

            DB::commit();

            return ResponseService::responseSuccess(
                new OrderResource($order),
                'Order updated successfully'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order update failed: ' . $e->getMessage());
            return ResponseService::responseError(
                'Failed to update order',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Delete an order
     */
    public function delete_order($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return ResponseService::responseError(
                'Order not found',
                Response::HTTP_NOT_FOUND
            );
        }

        if ($order->status != 'completed') {
            event(new OrderCancelled($order));
        }
        $order->delete();

        return ResponseService::responseSuccess(
            null,
            'Order deleted successfully'
        );
    }
}
