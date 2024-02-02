<?php

namespace App\Http\Requests\PosCustomOrder;

use Illuminate\Foundation\Http\FormRequest;

class PosCustomOrderReverseRequest extends FormRequest
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
            'status_remark' =>  ['required','string'],
        ];
    }
}
