<?php

namespace App\Http\Requests\API\Admin\V1\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CartAttributeRequest extends FormRequest
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
            "attributes" => ["nullable","sometimes","string"],
        ];
    }
}