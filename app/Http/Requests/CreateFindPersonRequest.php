<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateFindPersonRequest extends FormRequest
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
            'missing_id' => 'required',
            'filename' => 'required|mimes:jpeg,jpg,bmp,png,gif,ico,apng,bmp,svg,tiff,webp|min:24|max:5120', // file type : jpeg,jpg,bmp,png, min size : 24kb , max size : 5 mb 1024*5 = 5120
            'message' => 'required'
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
            'missing_id.required' => 'Missing Person Id not found..!',
            'message.required' => 'Message field is required..!',
            'filename.required' => 'File upload file is required..!',
            // 'filename.*' => 'File type must be jpg,png or bmp...!',
            'filename.mimes' => 'File type must be jpeg, jpg, bmp, png, gif, ico, apng, bmp, svg, tiff or webp..!',
            'filename.min' => 'Minimum file size must be 24KB...!',
            'filename.max' => 'Maximum file size must be 5MB...!'
        ];
    }
}
