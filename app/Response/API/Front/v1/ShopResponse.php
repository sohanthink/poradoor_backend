<?php

namespace App\Response\API\Front\v1;

use App\Models\Product;
use App\Models\Category;
use App\Traits\APIResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\API\Admin\v1\ProductResource;
use App\Http\Resources\API\Admin\v1\CategoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\API\Front\v1\Category\CategoryDetailsResource;
use App\Http\Resources\API\Front\v1\Product\ProductLiteWeightResource;

class ShopResponse{
    use APIResponse;
    public function product_details_response(Product $product): JsonResponse{
        return $this->success(message: "Fetch Product Details Success.",data: ProductResource::make($product));
    }
    public function category_details_response(Category $category): JsonResponse{
        return $this->success(message: "Fetch Ctaegory Details With Product Success.",data: CategoryDetailsResource::make($category));
    }
    public function products_response(AnonymousResourceCollection $products): JsonResponse{
        return $this->success(message: "Fetch Products Success.",data: ProductLiteWeightResource::collection($products));
    }
    public function category_response(AnonymousResourceCollection $categories): JsonResponse{
        return $this->success(message: "Fetch Category Success.",data: CategoryResource::collection($categories));
    }
}