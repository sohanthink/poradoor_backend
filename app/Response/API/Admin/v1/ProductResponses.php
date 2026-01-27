<?php

namespace App\Response\API\Admin\v1;

use App\Http\Resources\API\v1\ProductResource;
use App\Models\Product;
use App\Traits\APIResponse;

class ProductResponses
{
    use APIResponse;
    public function product_create_success_response(Product $product)
    {
        return $this->success(data: ProductResource::make($product), message: "Product Created Successfully",code: 201);
    }
    public function product_update_success_response(Product $product)
    {
        return $this->success(data: ProductResource::make($product), message: "Product Updated Successfully");
    }
    public function product_error_response()
    {
        return $this->error(message: "Error! Something Went Wrong.");
    }
    public function product_delete_success_response()
    {
        return $this->success(message: "Product Deleted Successfully");
    }
}
