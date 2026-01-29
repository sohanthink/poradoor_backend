<?php

namespace App\Http\Controllers\API\Admin\v1;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\API\Admin\v1\CategoryService;
use App\Response\API\Admin\v1\CategoryResponses;
use App\Http\Requests\API\Admin\v1\CategoryRequest;

class CategoryController extends Controller
{
    private $category_service;
    private $category_response;
    public function __construct(){
        $this->category_service = new CategoryService();
        $this->category_response = new CategoryResponses();
    }
    public function index(){
        return $this->category_service->get_categories();
    }
    public function show(Category $category){
        return $category;
    }
    public function store(CategoryRequest $request, Category $category = null): JsonResponse{
        $is_create = $category? false: true;
        $category = $this->category_service->save_category(data: $request->validated(),category: $category);
        if($category){
            return $is_create? 
                $this->category_response->category_create_success_response(categoy: $category): 
                $this->category_response->category_update_success_response(categoy: $category);
        }
        return $this->category_response->category_error_response();
    }
    public function delete(Category $category){
        if($category->id == 1){
            return $this->category_response->first_category_delete_error_response();
        }
        if($this->category_service->delete_category($category)){
            return $this->category_response->category_delete_success_response();
        }
        return $this->category_response->category_error_response();
    }
}
