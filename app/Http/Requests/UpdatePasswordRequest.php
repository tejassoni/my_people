<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;

class UpdatePasswordRequest extends FormRequest
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
        return [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => [
                'required',
                'different:current_password',
                'string',
                'min:8',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/' // must contain a special character                
            ],
            'confirm_password' => 'required|same:new_password',
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
            'current_password.required' => 'Current Password field is required..!',
            'new_password.required' => 'New Password field is required..!',
            'new_password.different' => 'New Password field should be different from Current Password field..!',
            'new_password.min' => 'New Password field should be minimum 8 length..!',
            'new_password.regex' => 'New Password must contain at least one lowercase letter, at least one uppercase letter, at least one uppercase letter,at least one digit and at least one special character ..!',
            'confirm_password.required' => 'Confirm Password field is required..!',
            'confirm_password.same' => 'Confirm Password field must be same as New Password Field..!'
        ];
    }
}
