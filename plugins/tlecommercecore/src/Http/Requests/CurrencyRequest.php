<?php

namespace Plugin\TlcommerceCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
            'name' => 'required|unique:tl_com_currencies,name,' . request('id'),
            'symbol' => 'required',
            'code' => 'required|unique:tl_com_currencies,code,' . request('id'),
            'exchange_rate' => 'required',
            'position' => 'required'
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}