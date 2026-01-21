<?php

namespace App\Http\Requests\API\Front\User\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class UpdateUserRequest extends FormRequest
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
            'name' => ['required','string','max:255'],
            'email' => ['required','string','max:255','email', Rule::unique('users','email')->ignore($this->user()->id)],
            'number' => ['required','string','max:255', Rule::unique('users','number')->ignore($this->user()->id)],
            'address' => ['nullable','sometimes','string','max:512']
        ];
    }
}
