<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateFindPersonResponse extends FormRequest
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
            'find_id_hidden' => 'required',
            'missing_id_hidden' => 'required',
            'status_select' => 'required',
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
            'find_id_hidden.required' => 'Find Person Id not found..!',
            'missing_id_hidden.required' => 'Missing Person Id not found..!',
            'status_select.required' => 'Status field is required..!',
        ];
    }
}
