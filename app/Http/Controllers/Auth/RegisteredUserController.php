<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Jobs\SendMailRegisterUser;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request): JsonResponse
    {
        if (User::where('email', '=', $request->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Email já existente na base de dados'
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
            'mail_token_confirm' => Hash::make($request->email)
        ]);

        SendMailRegisterUser::dispatch($user);
        event(new Registered(user: $user));
        return response()->json([
            'error' => true,
            'msg' => 'Usuário cadastrado com sucesso!',
            'user' => $user
        ]);
    }

    public function confirmUser(string $token)
    {
        if(empty($token)){
            echo "Token inválido";
        }

        $user = User::where('mail_token_confirm', '=', $token)->first();
        if(empty($user)){
            echo "Token inválido";
        }

        $user->ativo = 1;
        $user->save();

        echo "Usuário validado com sucesso";
    }
}
