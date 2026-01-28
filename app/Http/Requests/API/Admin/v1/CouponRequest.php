<?php

namespace App\Http\Requests\API\Admin\v1;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
        $is_update = $this->isMethod('put') || $this->isMethod('patch');
        $coupon_id = $this->route('coupon'); 
        $coupon_validation = [
            $is_update? 'nullable': 'required',
            'string',
            'max:50',
            'min:5', 
        ];
        $is_update ? null: $coupon_validation[] = Rule::unique('coupons','coupon')->ignore($coupon_id);   
        return [
            "type" => ['nullable','numeric'],
            "coupon" => $coupon_validation,
            "limit" => ['nullable','numeric','min:1'],
            "usage" => ['nullable','numeric','min:1'],
            "value" => ['nullable','numeric'],
            "vaild_till" => ['nullable','date'],
            "product_include" => ["nullable", "sometimes", "array"], 
            "product_include.*" => ["exists:products,id"],
            "product_exclude" => ["nullable", "sometimes", "array"], 
            "product_exclude.*" => ["exists:products,id"],
            "status" => ['nullable','boolean'],
        ];
    }
    public function messages(){
        return [
            'coupon.unique' => "This Coupon Already Exist",
            'product_include.*.exists' => "Product Does Not Exist With One Of The Id",
            'product_exclude.*.exists' => "Product Does Not Exist With One Of The Id",
        ];
    }
}
