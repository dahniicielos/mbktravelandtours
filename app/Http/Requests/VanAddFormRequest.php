<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VanAddFormRequest extends FormRequest
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
            'brand' => 'required',
            'model' => 'required',
            'no_of_seats' => 'required',
            'description' => 'required',
            'van_image' => 'required|image|mimes:jpeg,bmp,png|max:2000'
        ];
    }
}
