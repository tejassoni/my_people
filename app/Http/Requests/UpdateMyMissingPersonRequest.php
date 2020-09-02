<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMyMissingPersonRequest extends FormRequest
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
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required',
            'age' => 'required|max:3',
            'height' => 'required|max:3',
            'weight' => 'required|max:3',
            'address' => 'required',
            'country_select' => 'required',
            'state_select' => 'required',
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
            'height.required' => 'Height field is required..!',
            'height.integer' => 'Height field field is must be Integer..!',
            'height.max' => 'Height 3 length allowed..!',
            'weight.required' => 'Weight field is required..!',
            'weight.integer' => 'Weight field field is must be Integer..!',
            'weight.max' => 'Weight 3 length allowed..!',
            'address.required' => 'Address field is required..!',
            'country_select.required' => 'Country field is required..!',
            'state_select.required' => 'State field is required..!',
            'pincode.required' => 'Pincode field is required..!',
            'pincode.integer' => 'Pincode field is must be Integer..!',
            'missing_date.required' => 'Missing Date field is required..!',
            'remark.required' => 'Remark field is required..!',
            'cloth_description.required' => 'Coth Description field is required..!',
            'filename.required' => 'Missing Person Image upload file is required..!',
            // 'filename.*' => 'File type must be jpg,png or bmp...!',
            'filename.mimes' => 'Missing Person Image type must be jpeg, jpg, bmp, png, gif, ico, apng, bmp, svg, tiff or webp..!',
            'filename.min' => 'Missing Person Image Minimum file size must be 24KB...!',
            'filename.max' => 'Missing Person Image Maximum file size must be 5MB...!'
        ];
    }
}
