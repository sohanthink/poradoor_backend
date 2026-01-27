<?php

namespace App\Response\API\Admin\v1;


use App\Models\Category;
use App\Traits\APIResponse;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\API\Admin\v1\CategoryResource;


class CategoryResponses
{
    use APIResponse;
    public function category_create_success_response(Category $categoy): JsonResponse{
        return $this->success(data: CategoryResource::make($categoy), message: "Category Created Successfully",code: 201);
    }
    public function category_update_success_response(Category $categoy): JsonResponse{
        return $this->success(data: CategoryResource::make($categoy), message: "Category Updated Successfully");
    }
    public function category_error_response(){
        return $this->error(message: "Error! Something Went Wrong.");
    }
    public function first_category_delete_error_response(){
        return $this->error(message: "You Cannot Delete This Category.");
    }
    public function category_delete_success_response(){
        return $this->success(message: "Category Deleted Successfully");
    }
}
