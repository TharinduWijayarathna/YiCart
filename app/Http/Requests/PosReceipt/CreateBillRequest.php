<?php

namespace App\Http\Requests\PosReceipt;

use Illuminate\Foundation\Http\FormRequest;

class CreateBillRequest extends FormRequest
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
            'balance' => ['required', 'numeric', 'min:1'],
            'remark' => ['nullable', 'string', 'max:120'],
        ];
    }
    function messages()
    {
        return[
            'balance.required' => ' The paid amount is required',
        ];
    }
}
