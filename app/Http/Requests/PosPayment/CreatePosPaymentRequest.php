<?php

namespace App\Http\Requests\PosPayment;

use Illuminate\Foundation\Http\FormRequest;

class CreatePosPaymentRequest extends FormRequest
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
            'order_id'=>  ['required','numeric'],
            'customer_id'=>  ['nullable','numeric'],
            'customer_type'=>  ['nullable','string'],
            'card'=>  ['nullable','numeric','min:0'],
            'cash'=>  ['nullable','numeric','min:0'],
            'visa'=>  ['nullable','numeric','min:0'],
            'credit'=>  ['nullable','numeric','min:0'],
            'amex'=>  ['nullable','numeric','min:0'],
            'voucher'=>  ['nullable','numeric','min:0'],
            'total_amount'=>  ['required','numeric'],
            'payed_amount'=>  ['required','numeric','min:0'],
            'sales_person_id'=>  ['nullable','numeric'],
        ];
    }

    public function messages()
    {
        return [
            'payed_amount.required' => "At least pay with one method!",
            'sales_person_id.required' => "Please select sales person!",
        ];
    }
}
