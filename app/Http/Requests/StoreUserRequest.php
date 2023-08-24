<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $this->email = $this->email.'@pribadidepok.sch.id';
        return [
            'email' => 'required|unique:users|max:25',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ];
    }
}
