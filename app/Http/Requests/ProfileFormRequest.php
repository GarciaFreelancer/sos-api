<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileFormRequest extends FormRequest
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
            'profession' => 'max:200',
            'about' => 'required | min:5',
            'facebook_url' => 'url',
            'linkedin_url' => 'url'
        ];
    }

    public function messages()
    {
        return [
            'profession.max' => 'Nome da sua profissão ficou demasiado grande, por favor reduz o número de letras',
            'about.min' => 'Precisa preencher ao mínimo 5 caracteres ao falar sobre ti!',
            'about.required' => 'Falar um pouco sobre você é obrigatório!',
            'facebook_url.url' => 'O endereço do Facebook deve ser verdadeiro e completo',
            'linkedin_url.url' => 'O endereço do LinkedIn deve ser verdadeiro e completo'
        ];
    }
}
