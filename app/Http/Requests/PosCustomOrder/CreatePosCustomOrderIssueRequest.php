<?php

namespace App\Http\Requests\PosCustomOrder;

use Illuminate\Foundation\Http\FormRequest;

class CreatePosCustomOrderIssueRequest extends FormRequest
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
            'order_item_id' =>  ['required','numeric'],
            'order_id' =>  ['required','numeric'],
            'quantity' =>  ['required','numeric', 'min:0'],
            'product_name' =>  ['required','string'],
        ];
    }

    public function messages()
    {
        return [
            'order_item_id.required' => "Product is required."
        ];
    }
}
