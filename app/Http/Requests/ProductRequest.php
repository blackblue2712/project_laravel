<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'txtName' => 'required|unique:product,name',
            'txtPrice' => 'required',
        ];
    }


    public function messages(){
        return [
            'txtName.required' => 'Please enter product name',
            'txtName.unique' => 'The product name already exists',
            'txtPrice.required' => 'Please enter price',
        ];
    }
}
