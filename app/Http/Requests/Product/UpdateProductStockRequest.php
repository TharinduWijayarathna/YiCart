<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductStockRequest extends FormRequest
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
            'new_quantity' => 'required|numeric|min:1',
            'cost' => 'nullable|numeric|min:0',
            'transaction_type_id' => 'required|numeric',
            'supplier_id' => 'nullable',
            // 'supplier_id' => [
            //     'required_if:transaction_type_id,1',
            //     'numeric',
            // ],
            'remark' => 'nullable|string',
            'po_number' => 'nullable|string',
            'date' => 'required|date',
        ];
    }
    function messages()
    {
        return[
            'new_quantity.required' => ' Quantity Field Is Required.',
            'transaction_type_id.required' => 'Transaction Type Is Required.',
            'date.required' => ' Date Field Is Required.',
        ];
    }
}
