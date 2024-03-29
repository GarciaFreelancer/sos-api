<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSituationtFormUpdateRequest extends FormRequest
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
            'title' => 'min:2 | max:200',
            'description' => 'min:2'
        ];
    }
}
