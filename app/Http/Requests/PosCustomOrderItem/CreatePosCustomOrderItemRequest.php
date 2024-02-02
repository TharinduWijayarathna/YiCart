<?php

namespace App\Http\Requests\PosCustomOrderItem;

use Illuminate\Foundation\Http\FormRequest;

class CreatePosCustomOrderItemRequest extends FormRequest
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
            'product_id' =>  ['nullable','numeric'],
            'product_name' =>  ['required','string'],
            'description' =>  ['nullable','string'],
            'size' =>  ['required','string'],
            'quantity' =>  ['required','numeric'],
            'unit_price' =>  ['required','numeric'],
            'remark' =>  ['nullable','string'],
        ];
    }
}
