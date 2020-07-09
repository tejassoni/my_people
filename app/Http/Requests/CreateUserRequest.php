<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // if(Auth()::user()->can('manage-roles')){
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
        // dd($_REQUEST);
        return [
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'user_address' => 'required',
            'mobile' => 'required',
            'email' => 'required|email|unique:user_master,email',
            'password' => [
                'required',
                'string',
                'min:8',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/' // must contain a special character                
            ],
            'confirm_password' => 'required|same:password',
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
            'password.required' => 'Password field is required..!',
            'password.min' => 'Password field should be minimum 8 length..!',
            'password.regex' => 'Password must contain at least one lowercase letter, at least one uppercase letter, at least one uppercase letter,at least one digit and at least one special character ..!',
            'confirm_password.required' => 'Confirm Password field is required..!',
            'confirm_password.same' => 'Confirm Password field must be same as Password Field..!',
            'role_id_select.required' => 'Role field is required..!',
            'subscription_id_select.required' => 'Subscription field is required..!'
        ];
    }
}
