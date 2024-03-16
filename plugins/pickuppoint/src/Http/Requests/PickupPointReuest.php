<?php
namespace Plugin\PickupPoint\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PickupPointReuest extends FormRequest{
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
                'name' => 'required|unique:tl_pick_up_points,name,'.request('id'),
                'phone' => 'required',
                'location' => 'required',
                'zone' => 'required|exists:tl_com_shipping_zones,id'
            ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            
        ];
    }
}