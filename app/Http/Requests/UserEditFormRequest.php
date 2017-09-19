<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEditFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'middle_initial' => '',
            'last_name' => 'required',
            'phone_number' => '',
            'city' => '',
            'province' => '',
            'birthday' => 'date',
            'profile_pictre' => 'image|mimes:jpeg,bmp,png|max:2000',
            
        ];
        //
    }
}
