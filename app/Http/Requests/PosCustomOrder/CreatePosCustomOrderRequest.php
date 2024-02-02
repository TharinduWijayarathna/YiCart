<?php

namespace App\Http\Requests\PosCustomOrder;

use Illuminate\Foundation\Http\FormRequest;

class CreatePosCustomOrderRequest extends FormRequest
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
        'customer_id' =>  ['required','numeric'],
        'delivery_date' =>  ['required','date'],
        'payment_status' =>  ['nullable','numeric'],
        'extra_charges' =>  ['nullable','numeric'],
        'order_type' =>  ['nullable','string'],
        'contact_at' =>  ['required','string'],
        ];
    }
}
