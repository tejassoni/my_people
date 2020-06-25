<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $user_id = self::segment(3);
        return [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'email' => "required|email|unique:user_master,email,$user_id",
            'user_address' => 'required',
            'mobile' => 'required',
            'role_id_select' => 'required',
            'subscription_id_select' => 'required'
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
            'first_name.required' => 'FirstName field is required..!',
            'middle_name.required' => 'MiddleName field is required..!',
            'last_name.required' => 'LastName field is required..!',
            'user_address.required' => 'Address field is required..!',
            'mobile.required' => 'Mobile field is required..!',
            'email.required' => 'Email field is required..!',
            'email.email' => 'Email Address is not Proper..!',
            'email.unique' => 'Email Address is Already Exist in Our System..! Please try with Different Email Address..!',
            'role_id_select.required' => 'Role field is required..!',
            'subscription_id_select.required' => 'Subscription field is required..!'
        ];
    }
}
