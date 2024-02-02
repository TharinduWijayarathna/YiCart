<?php

namespace App\Http\Requests\Configuration;

use Illuminate\Foundation\Http\FormRequest;

class CreateConfigurationRequest extends FormRequest
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
            'image' => ['nullable', 'image', 'max:4096'],
            'name' => ['required', 'string', 'max:120'],
            'address' => ['nullable', 'string', 'max:255'],
            'mobile' =>  ['nullable', 'numeric', 'digits_between:9,15'],
            'email' =>  ['nullable', 'email', 'max:255'],
            'footer' => ['nullable', 'string', 'max:120'],
        ];
    }
    function messages()
    {
        return[
            'name.required' => "The business name is required.",
        ];
    }
}
