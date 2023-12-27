<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class checkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Product_name' =>'required',
            'description'=>'required',
            'section_id'=>'required',

        ];
    }
}
