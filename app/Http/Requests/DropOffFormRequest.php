<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DropOffFormRequest extends FormRequest
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
            'origin_id' => 'required',
            'destination_id' => 'required|different:origin_id',
            'drop_off_point_id' => 'required'
        ];
    }
}
