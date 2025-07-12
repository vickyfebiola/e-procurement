<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_name' => ['required'],
            'description' => ['nullable'],
            'price' => ['required', 'numeric', 'min:0'],
            'id_vendor' => ['nullable', 'exists:vendors,id_vendor'],
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => 'Product name is required',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price must be at least 0',
            'id_vendor.exists' => 'Vendor does not exist',
        ];
    }
}
