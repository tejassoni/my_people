<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteUserRoleRequest extends FormRequest
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
            'ids' => 'required',
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
            'ids.required' => 'Atleast one role must be select..!',
        ];
    }
}
