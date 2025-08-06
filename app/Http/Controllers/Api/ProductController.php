<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Services\ResponseService;
use App\Http\Resources\ProductResource;
use App\Http\Requests\Api\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Product::paginate(15);
        return ResponseService::responseSuccess(ProductResource::collection($data)->response()->getData());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        //
        $data = $request->validated();
        $product = Product::create($data);
        return ResponseService::responseSuccess(new ProductResource($product), 'Product added successfully', Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $data = $request->validated();
        unset($data['stock']);

        $product = Product::find($id);
        if (!$product) {
            return ResponseService::responseError('Product not found', Response::HTTP_NOT_FOUND);
        }
        $product->update($data);
        return ResponseService::responseSuccess(new ProductResource($product), 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::whereDoesntHave('orders')->find($id);
        if (!$product) {
            return ResponseService::responseError('Product not found or has orders' , Response::HTTP_NOT_FOUND);
        }
        $product->delete();
        return ResponseService::responseSuccess(null, 'Product deleted successfully');
    }
}
