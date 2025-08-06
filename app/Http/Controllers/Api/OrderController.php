<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderRequest;
use App\Http\Requests\Api\UpdateOrderRequest;
use App\Http\Services\OrderService;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    protected $order_service;

    public function __construct(OrderService $order_service)
    {
        $this->order_service = $order_service;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        return $this->order_service->create_order($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->order_service->get_order($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, string $id)
    {
        return $this->order_service->update_order($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->order_service->delete_order($id);
    }



}
