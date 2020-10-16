<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionRequest extends FormRequest
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
            'sub_name' => 'required', // unique ignore for current table subscription id, define subscription name & value       
            'sub_alias' => "required|unique:subscription_master,sub_alias,$sub_id,sub_id|max:10",
            'plan_id_select' => 'required',
            'sub_validity' => 'required|integer|min:1',
            'sub_description' => 'required'
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
            'sub_name.required' => 'Subscription Name field is required..!',
            'plan_id_select.required' => 'Subscription Plan field is required..!',
            'sub_alias.required' => 'Subscription Alias field is required..!',
            'sub_alias.unique' => 'Subscription Alias field should be Unique..!',
            'sub_alias.max' => 'Subscription Alias field max charcter 10 allowed..!',
            'sub_description' => 'required',
            'sub_validity.required' => 'Subscription Validity field is required..!',
            'sub_validity.integer' => 'Subscription Validity field must be in numbers..!',
            'sub_validity.min' => 'Subscription Validity field minimum 1 Day..!'
        ];
    }
}
