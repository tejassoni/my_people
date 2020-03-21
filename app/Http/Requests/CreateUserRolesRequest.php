<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateUserRolesRequest extends FormRequest
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
        return [           
                'role_name' => 'required',
                'role_alias' => 'required|unique:role_master,role_alias|max:10',
                'role_description' => 'required'            
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
                'role_name.required' => 'Role Name field is required..!',
                'role_alias.required' => 'Role Alias field is required..!',
                'role_alias.unique' => 'Role Alias field should be Unique..!',
                'role_alias.max' => 'Role Alias field max charcter 10 allowed..!',
                'role_description' => 'required'            
        ];
    }

}
