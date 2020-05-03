<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateJawMasterRequest extends FormRequest
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
            'jaw_name' => 'required',
            'jaw_color' => 'required',
            'filename' => 'required|mimes:jpeg,jpg,bmp,png|min:24|max:5120', // file type : jpeg,jpg,bmp,png, min size : 24kb , max size : 5 mb 1024*5 = 5120
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
            'jaw_name.required' => 'Name field is required..!',
            'jaw_color.required' => 'Color field is required..!',
            'filename.required' => 'File upload file is required..!',
            // 'filename.*' => 'File type must be jpg,png or bmp...!',
            'filename.mimes' => 'File upload file is required..!',
            'filename.min' => 'Minimum file size must be 24KB...!',
            'filename.max' => 'Maximum file size must be 5MB...!'
        ];
    }
}
