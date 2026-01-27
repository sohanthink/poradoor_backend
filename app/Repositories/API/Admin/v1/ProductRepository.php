<?php

namespace App\Repositories\API\Admin\v1;

use App\Models\Product;
use App\DTOs\Product\ProductDTO;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository
{
    /**
     * Save A Product Instance To The Database
     * @return LengthAwarePaginator
     */
    public function products(): LengthAwarePaginator{
        $products = Product::with('category')->paginate(config('model.paginate_limit'));
        return $products;
    }
    /**
     * Save A Product Instance To The Database
     * @param ProductDTO $dto
     * @param Product $product
     * @return Product
     */
    public function store(ProductDTO $dto, Product $product = null): Product{
        if($product){
            $product->update(attributes: $dto->to_array());
            return $product;
        }
        return Product::create(attributes: $dto->to_array());
    }
    public function delete(Product $product): bool|null{
        $product->clearMediaCollection();
        return $product->delete();
    }
}
