<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class RecoveryPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $currentRoute = explode('.', Route::currentRouteName());
        switch(end($currentRoute)){
            case 'passwordResetLink':
                return [
                    'email' => 'required|email'
                ];
            case 'setNewPassword':
                return[
                    'token' => 'required',
                    'password' => 'required',
                    'confirm_password' => 'required|same:password'
                ];

        }

    }

    public function messages(): array
    {
        return [
            'required' => 'Campo obrigatório',
            'email' => 'O campo deve ser um e-mail válido',
            'same' => 'Confirmação da senha deve ser igual a senha informada'
        ];
    }
}
