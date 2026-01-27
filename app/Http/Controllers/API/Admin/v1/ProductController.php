<?php

namespace App\Http\Controllers\API\Admin\v1;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\API\Admin\v1\ProductService;
use App\Response\API\Admin\v1\ProductResponses;
use App\Http\Requests\API\Admin\v1\ProductRequest;

class ProductController extends Controller
{
    private $product_service;
    private $product_response;
    public function __construct()
    {
        $this->product_service = new ProductService();
        $this->product_response = new ProductResponses();
    }
    public function index()
    {
        return $this->product_service->get_products();
    }
    public function store(ProductRequest $request, Product $product = null): JsonResponse
    {
        $is_create = $product ? false : true;
        $product = $this->product_service->save_product(data: $request->validated(), product: $product);
        if ($product) {
            return $is_create ?
                $this->product_response->product_create_success_response(product: $product) :
                $this->product_response->product_update_success_response(product: $product);
        }
        return $this->product_response->product_error_response();
    }
    public function delete(Product $product)
    {
        if ($this->product_service->delete_product($product)) {
            return $this->product_response->product_delete_success_response();
        }
        return $this->product_response->product_error_response();
    }
}
