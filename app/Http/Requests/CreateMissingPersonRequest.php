<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateMissingPersonRequest extends FormRequest
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
            'filename' => 'required|mimes:jpeg,jpg,bmp,png,gif,ico,apng,bmp,svg,tiff,webp|min:24|max:5120', // file type : jpeg,jpg,bmp,png, min size : 24kb , max size : 5 mb 1024*5 = 5120
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required',
            'age' => 'required|max:3',
            'address' => 'required',
            'country_select' => 'required',
            'state_select' => 'required',
            'city_select' => 'required',
            'pincode' => 'required:integer',
            'missing_date' => 'required',
            'remark' => 'required',
            'cloth_description' => 'required'
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
            'first_name.required' => 'First Name field is required..!',
            'middle_name.required' => 'Middle Name field is required..!',
            'last_name.required' => 'Last Name field is required..!',
            'birth_date.required' => 'Birth Date field is required..!',
            'age.required' => 'Age field is required..!',
            'age.max' => 'Age 3 length allowed..!',
            'address.required' => 'Address field is required..!',
            'country_select.required' => 'Country field is required..!',
            'state_select.required' => 'State field is required..!',
            'city_select.required' => 'City field is required..!',
            'pincode.required' => 'Pincode field is required..!',
            'pincode.integer' => 'Pincode field is must be Integer..!',
            'missing_date.required' => 'Missing Date field is required..!',
            'remark.required' => 'Remark field is required..!',
            'cloth_description.required' => 'Coth Description field is required..!',
            'filename.required' => 'File upload file is required..!',
            // 'filename.*' => 'File type must be jpg,png or bmp...!',
            'filename.mimes' => 'File type must be jpeg, jpg, bmp, png, gif, ico, apng, bmp, svg, tiff or webp..!',
            'filename.min' => 'Minimum file size must be 24KB...!',
            'filename.max' => 'Maximum file size must be 5MB...!'
        ];
    }
}
