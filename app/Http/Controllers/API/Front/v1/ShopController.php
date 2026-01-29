<?php

namespace App\Http\Controllers\API\Front\v1;

use App\Http\Requests\API\Front\Shop\ProductFilterRequest;
use App\Http\Resources\API\Front\v1\Product\ProductLiteWeightResource;
use App\Models\Category;
use App\Models\Product;
use App\Response\API\Front\v1\ShopResponse;
use App\Services\API\Admin\v1\CategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\API\Admin\v1\ProductService;
use App\Http\Resources\API\Admin\v1\ProductResource;

class ShopController extends Controller
{
    protected $product_service;
    protected $category_service;
    protected $shop_response;
    public function __construct(){
        $this->product_service = new ProductService();
        $this->category_service = new CategoryService();
        $this->shop_response = new ShopResponse();
    }
    public function products(){
        return $this->shop_response->products_response(products: $this->product_service->get_products());
    }
    public function categories(){
        return $this->shop_response->category_response(categories: $this->category_service->get_categories());
    }
    public function product_filter(ProductFilterRequest $request){
        return ProductLiteWeightResource::collection($this->product_service->filter($request->validated()));
    }
    public function product_details(Product $product){
        return $this->shop_response->product_details_response($product);
    }
    public function category_details(Category $category){
        $category->load('products');
        return $this->shop_response->category_details_response($category);
    }
}
