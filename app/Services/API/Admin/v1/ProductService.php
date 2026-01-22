<?php

namespace App\Services\API\Admin\v1;

use App\Models\Product;
use App\DTOs\Product\Create;
use App\Helpers\ImageHelper;
use App\Http\Resources\API\v1\ProductResource;
use App\Repositories\API\Admin\v1\ProductRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductService
{
    private $repository;
    public function __construct()
    {
        $this->repository = new ProductRepository();
    }
    /**
     * Create a new product or update existing product
     * @param array $data
     * @param Product $product
     * @return AnonymousResourceCollection
     */
    public function get_products(): AnonymousResourceCollection
    {
        $products = $this->repository->products();
        return ProductResource::collection($products);
    }
    /**
     * Create a new product or update existing product
     * @param array $data
     * @param Product $product
     * @return Product
     */
    public function save_product(array $data, Product $product = null): Product
    {
        $dto = Create::fromRequest(data: $data);
        $product = $this->repository->store(dto: $dto, product: $product);
        if (request()->hasFile('hero_image')) {
            ImageHelper::uploadImage($product, request(), 'hero_image');
        }
        if (request()->hasFile('secondary_image')) {
            ImageHelper::uploadImage($product, request(), 'secondary_image');
        }
        if (request()->hasFile('images')) {
            ImageHelper::uploadMultipleImages($product, request(), 'images');
        }
        return $product;
    }

    /**
     * Delete a product
     * @param array $data
     * @param Product $product
     * @return bool|null
     */
    public function delete_product(Product $product): bool|null
    {
        return $this->repository->delete($product);
    }
}
