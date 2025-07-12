<?php

namespace App\Http\Requests\Vendor;

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
            'vendor_name' => ['required'],
            'address' => ['required'],
            'is_default' => ['nullable', 'in:0,1'],
        ];
    }

    public function messages()
    {
        return [
            'vendor_name.required' => 'Vendor name is required',
            'address.required' => 'Address is required',
            'is_default.in' => 'Default value must be either 0 or 1',
        ];
    }
}
