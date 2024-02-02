<?php

namespace App\Http\Requests\ReturnItems;

use Illuminate\Foundation\Http\FormRequest;

class AddItemsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'unit_price' => 'required|numeric|min:0',
            'quantity' => 'required|numeric',
            'customer_id'=>'nullable',

        ];
    }

    public function messages()
    {
        return [
            'product_id.required' => 'Product is required',
            'unit_price.required' => 'Price is required',
            'unit_price.numeric' => 'Price must be a number',
            'unit_price.min' => 'Price must be valid number',
        ];
    }
}
