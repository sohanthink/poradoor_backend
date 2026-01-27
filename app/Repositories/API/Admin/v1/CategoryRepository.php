<?php

namespace App\Repositories\API\Admin\v1;

use App\Models\Category;
use App\DTOs\Category\Create;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository
{
   
    /**
     * Save A Category Instance To The Database
     * @return LengthAwarePaginator
     */
    public function categories(): LengthAwarePaginator{
        $categories = Category::with('subcategories')->paginate(config('model.paginate_limit'));
        return $categories;
    }
    /**
     * Save A Category Instance To The Database
     * @param Create $dto
     * @param Category $category
     * @return Category
     */
    public function store(Create $dto, Category $category = null): Category{
        if($category){
            $category->update(attributes: $dto->toArray());
            return $category;
        }
        return Category::create(attributes: $dto->toArray());
    }

    /**
     * Delete A Category Instence
     * @param Category $category
     * @return bool|null
     */

    public function delete(Category $category): bool|null{
        return $category->delete();
    }

    /**
     * Batch Delete A Category Collection
     * @param Category|null $category
     * @return bool
     */
    public function batch_delete(Collection|null $categories): bool{
        if($categories){
            $categories->each->delete();
        }
        return true;
    }
}
