<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockRequest extends FormRequest
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
            'transaction_type_id' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric', 'min:1'],
            'remarks' => ['nullable', 'string', 'max:120'],
        ];
    }
    function messages()
    {
        return[
            'transaction_type_id.required' => ' The transaction type is required',
            'quantity.required' => ' The quantity is required',
        ];
    }
}
