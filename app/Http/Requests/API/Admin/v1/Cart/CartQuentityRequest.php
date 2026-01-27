<?php

namespace App\Http\Requests\API\Admin\V1\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CartQuentityRequest extends FormRequest
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
            "guest_id" => ["nullable","sometimes","string","max:50"],
            "cart_item_id" => ["required","exists:cart_items,id"],
            "quantity" => ["required","numeric","min:1"],
        ];
    }
    public function messages(): array{
        return [
            "cart_item_id.exists" => "Cart Item Not Found",
        ];
    }
}