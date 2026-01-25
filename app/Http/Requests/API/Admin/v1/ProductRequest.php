<?php

namespace App\Http\Requests\API\Admin\v1;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => ["required","string","max:255"],
            "hero_image" => ["nullable", "sometimes","file","image","mimes:png,jpg,jpeg,webp"],
            "secondary_image" => ["nullable", "sometimes","file","image","mimes:png,jpg,jpeg,webp"],
            "images" => ["nullable", "sometimes", "array", "max:5"], 
            "images.*" => ["file", "image", "mimes:png,jpg,jpeg,webp", "max:2048"],
            "small_desc" => ["required","string","max:512"],
            "desc" => ["required","string"],
            "price" => ["required","numeric","min:1"],
            "regular_price" => ["nullable","numeric","min:1"],
            "atributes" => ["nullable","string"],
            "quantity" => ["required","numeric","min:1"],
            "alert_quantity" => ["required","numeric","min:1"],
            "status" => ["nullable","sometimes","numeric"],
            "category_id" => ["nullable","exists:categories,id"],
        ];
    }
}
