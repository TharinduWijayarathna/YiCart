<?php

namespace App\Http\Requests\PosOrderItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQtyRequest extends FormRequest
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
            'quantity' => 'required|numeric|min:1',
        ];
    }
    function messages()
    {
        return[
            'quantity.required' => ' Quantity Field Is Required.',
        ];
    }
}
