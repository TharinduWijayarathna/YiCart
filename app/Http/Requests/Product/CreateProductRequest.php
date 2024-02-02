<?php

namespace App\Http\Requests\Product;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'product_category_id' => ['nullable', 'numeric'],
            'cost' => ['nullable', 'numeric', 'min:0'],
            'selling' => ['required', 'numeric', 'min:1'],
            'stock_quantity' => ['nullable', 'numeric', 'min:0'],
            'unit' => ['nullable', 'numeric'],
            'image' => ['nullable', 'image', 'max:4096'],
            'description' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', 'boolean'],
        ];
    }
    function messages()
    {
        return[
            'name.required' => ' The product name is required',
            'selling.required' => ' The product selling price is required',
            'image.image' => ' The product image must be an image',
            'image.max' => ' The product image must be less than 4MB',
        ];
    }
}
