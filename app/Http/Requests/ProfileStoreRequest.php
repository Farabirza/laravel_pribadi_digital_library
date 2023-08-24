<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileStoreRequest extends FormRequest
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
            'user_id' => "required",
            'full_name' => "required|max:100",
            'gender' => "required",
            'role' => 'required',
            'grade' => '',
            'year_join' => '',
            'birth_place' => '',
            'birth_date' => '',
            'address_street' => "max:255",
            'address_city' => "max:24",
            'address_zip' => "",
            'languange' => "max:255",
            'interest' => "max:255",
            'biodata' => "max:500",
            'email' => "email|max:100",
        ];
    }
}
