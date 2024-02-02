<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'name' =>  ['required', 'string', 'max:255'],
            'address' =>  ['nullable', 'string', 'max:255'],
            'email' =>  ['nullable', 'email', 'max:255'],
            'email2' =>  ['nullable', 'email', 'max:255'],
            'email3' =>  ['nullable', 'email', 'max:255'],
            'contact' =>  ['required', 'numeric', 'digits_between:9,15'],
            'contact2' =>  ['nullable', 'numeric', 'digits_between:9,15'],
            'contact3' =>  ['nullable', 'numeric', 'digits_between:9,15'],
            'website' =>  ['nullable', 'string'],
            'customer_outstanding' => ['nullable', 'numeric', 'regex:/^\d{1,8}(\.\d{1,2})?$/'],

        ];
    }

    public function messages()
    {
        return [
            'name.required' => "The name field is required.",
            'contact.required' => "The contact field is required.",
        ];
    }
}
