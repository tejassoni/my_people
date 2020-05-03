<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHairMasterRequest extends FormRequest
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
        // Checkfor file updates
        if (self::hasFile('filename')) {
            return [ // New File upload is uploaded, File name will be update database
                'hair_style_name' => 'required',
                'hair_color' => 'required',
                'filename' => 'required|mimes:jpeg,jpg,bmp,png|min:24|max:5120', // file type : jpeg,jpg,bmp,png, min size : 24kb , max size : 5 mb 1024*5 = 5120
            ];
        } else { // File upload not changed, File name will remain same in database
            return [
                'hair_style_name' => 'required',
                'hair_color' => 'required'
            ];
        }
    }

    /**
     * Apply the validation rules messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'hair_style_name.required' => 'Name field is required..!',
            'hair_color.required' => 'Color field is required..!',
            'filename.required' => 'File upload file is required..!',
            // 'filename.*' => 'File type must be jpg,png or bmp...!',
            'filename.mimes' => 'File upload file is required..!',
            'filename.min' => 'Minimum file size must be 24KB...!',
            'filename.max' => 'Maximum file size must be 5MB...!'
        ];
    }
}
