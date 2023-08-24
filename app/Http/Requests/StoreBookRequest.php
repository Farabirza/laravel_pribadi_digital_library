<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
        return [
            'user_id' => 'required',
            'category' => 'required',
            'title' => 'required|max:100',
            'author' => 'max:100',
            'publisher' => 'max:100',
            'publication_year' => '',
            'isbn' => '',
            'summary' => 'max:1200',
            'description' => 'max:1200',
            'image' => '',
            'url' => 'required|max:255',
            'keywords' => 'max:100',
            'source' => 'max:1200',
            'access' => 'required',
        ];
    }
}
