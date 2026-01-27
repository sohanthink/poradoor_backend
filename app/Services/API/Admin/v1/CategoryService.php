<?php

namespace App\Services\API\Admin\v1;

use App\Models\Category;
use App\Helpers\ImageHelper;
use App\DTOs\Category\Create;
use App\Http\Resources\API\Admin\v1\CategoryResource;
use App\Repositories\API\Admin\v1\CategoryRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryService
{
    private $repository;
    public function __construct()
    {
        $this->repository = new CategoryRepository();
    }

    /**
     * Create a new category or update existing category
     * @param array $data
     * @param Category $category
     * @return AnonymousResourceCollection
     */
    public function get_categories(): AnonymousResourceCollection
    {
        $categories = $this->repository->categories();
        return CategoryResource::collection($categories);
    }
    /**
     * Create a new category or update existing category
     * @param array $data
     * @param Category $category
     * @return Category
     */
    public function save_category(array $data, Category $category = null): Category
    {
        $dto = Create::fromRequest(data: $data);
        $category = $this->repository->store(dto: $dto, category: $category);
        $media = null;
        if (request()->hasFile(key: 'image')) {
            $media = ImageHelper::uploadImage(model: $category, request: request());
            if($media){
                $category->image_url = $media?->getUrl();
            }
        }
        return $category;
    }

    /**
     * Delete a category
     * @param array $data
     * @param Category $category
     * @return bool|null
     */
    public function delete_subcategories($category)
    {
        $subcategories = $category->subcategories;
        $this->repository->batch_delete($subcategories);
    }

    /**
     * Delete a category
     * @param array $data
     * @param Category $category
     * @return bool|null
     */
    public function delete_category(Category $category): bool|null
    {
        $this->delete_subcategories($category);
        return $this->repository->delete($category);
    }
}
