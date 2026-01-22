<?php

namespace App\Repositories\API\Admin\v1;

use App\Models\Product;
use App\DTOs\Product\Create;
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
     * @param Create $dto
     * @param Product $product
     * @return Product
     */
    public function store(Create $dto, Product $product = null): Product{
        if($product){
            $product->update(attributes: $dto->toArray());
            return $product;
        }
        return Product::create(attributes: $dto->toArray());
    }
    public function delete(Product $product): bool|null{
        return $product->delete();
    }
}
