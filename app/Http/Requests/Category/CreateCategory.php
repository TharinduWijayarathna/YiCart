<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategory extends FormRequest
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
            'name' =>  ['required', 'string', 'max:255'],
            'remarks' =>  ['nullable', 'string'],

        ];
    }

    public function messages()
    {
        return [
            'name.required' => "The category name is required.",
        ];
    }
}
