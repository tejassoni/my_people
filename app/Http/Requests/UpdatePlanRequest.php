<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
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
        // get role id from URL routes dynamic passes id
        $plan_id = self::segment(3);
        return [
            'plan_name' => 'required', // unique ignore for current table role id, define role name & value       
            'plan_alias' => "required|unique:plan_master,plan_alias,$plan_id,plan_id|max:10",
            'plan_description' => 'required',
            'plan_amount' => 'required'
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
            'plan_name.required' => 'Plan Name field is required..!',
            'plan_alias.required' => 'Plan Alias field is required..!',
            'plan_alias.unique' => 'Plan Alias field should be Unique..!',
            'plan_alias.max' => 'Plan Alias field max charcter 10 allowed..!',
            'plan_description.required' => 'Plan Description field is required..!',
            'plan_amount.required' => 'Plan Amount field is required..!'
        ];
    }
}
