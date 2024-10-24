<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'password' => ['required', 'string'],
            'password_confirmation' => ['required', 'same:password']
        ];
    }

    public function messages():array
    {
        return [
            'required' => 'Campo obrigatório',
            'same' => 'Confirmação de senha deve ser igual a senha informada',
        ];
    }
}
