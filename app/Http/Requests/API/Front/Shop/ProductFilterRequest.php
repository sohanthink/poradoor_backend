<?php

namespace App\Http\Requests\API\Front\Shop;

use Illuminate\Foundation\Http\FormRequest;

class ProductFilterRequest extends FormRequest
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
            "price_from" => ["nullable","numeric","min:1"],
            "price_to" => ["nullable","numeric","min:2"],
            "category_slug" => ["nullable","exists:categories,slug"],
            "discounted" => ["nullable","boolean"],
        ];
    }
    public function messages(){
        return [
            "category_slug.exists" => "Category Does Not Exist",
        ];
    }
}
