<?php

namespace App\Http\Requests\PosAdvanceReceipt;

use Illuminate\Foundation\Http\FormRequest;

class CreatePosAdvanceReceiptRequest extends FormRequest
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
            'order_id' =>  ['nullable','numeric'],
            'date' =>  ['nullable','date'],
            'amount' =>  ['required','numeric'],
            'remark' =>  ['nullable','string'],
        ];
    }
}
