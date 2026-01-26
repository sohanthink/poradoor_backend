<?php

namespace App\Http\Requests\API\Admin\v1;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            "guest_id" => ["nullable","string","max:50"],
            "name" => ["required","string","min:3","max:50"],
            "email" => ["required","email","min:5","max:50"],
            "phone" => ["required","string","min:10","max:50","phone:US,BD,GB"],
            "city" => ["required","string","min:1","max:200"],
            "address" => ["required","string"],
            "delivary_area" => ["nullable","string"],
            "country" => ["nullable","string","min:4","max:100"],
            "zip_code" => ["nullable","string"],
            "additional_data" => ["nullable","string"],
            "payment_method" => ["required","numeric","min:0","max:1"],
            "shipping_method" => ["required","numeric","min:0","max:3"],
            "currency_id" => ["nullable","numeric","exists:currencies,id"],
            "currency_rate" => ["nullable","numeric"],
            "note" => ["nullable","string"],
            "save_shipping_address" => ["required","boolean"],
        ];
    }
}
