<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class updateCostingRequest extends FormRequest
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
            'expense_sub_category_id' => 'required',
            'expense_category_id' => 'required',
            'supplier_id' => 'nullable',
            'amount' => 'required|numeric',
            'quantity' => 'required|numeric',
            'remark' => 'nullable',
        ];
    }
}
