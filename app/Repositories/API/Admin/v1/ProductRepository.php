<?php

namespace App\Repositories\API\Admin\v1;

use App\Models\Product;
use App\DTOs\Product\ProductDTO;
use Illuminate\Database\Eloquent\Collection;
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
            $product->update(attributes: array_filter($dto->to_array()));
            return $product;
        }
        return Product::create(attributes: $dto->to_array());
    }
    /**
     * Filter Product
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function filter($data): LengthAwarePaginator{
        return Product::query()
            ->when(value: $data['price_from'] ?? null, callback: function ($query, $price) {
                $query->where('price', '>=', $price);
            })
            ->when($data['price_to'] ?? null, function ($query, $price) {
                $query->where('price', '<=', $price);
            })
            ->when($data['category_slug'] ?? null, function ($query, $slug) {
                $query->whereHas('category', fn($q) => $q->where('slug', $slug));
            })
            ->when($data['discounted'] ?? null, function ($query) {
                $query->whereNotNull('regular_price')
                    ->whereColumn('regular_price', '>', 'price'); 
            })->paginate(config('model.paginate_limit'));
    }
    public function delete(Product $product): bool|null{
        $product->clearMediaCollection();
        return $product->delete();
    }
}
