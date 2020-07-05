<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // if(Auth()::user()->can('manage-subscriptions')){
        //     return true;
        // }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // get subscription id from URL routes dynamic passes id
        $sub_id = self::segment(3);
        return [
            'discount_name' => 'required',
            'discount_description' => 'required',
            'discount_type_select' => 'required'
        ];
    }

    /**
     * Apply the validation rules messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'discount_name.required' => 'Discount Name field is required..!',
            'discount_description.required' => 'Discount Alias field is required..!',
            'discount_type_select' => 'Discount Type field is required..!'
        ];
    }
}
