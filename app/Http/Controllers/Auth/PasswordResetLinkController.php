<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RecoveryPasswordRequest;
use App\Jobs\SendMailRecoveryPassword;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Str;

class PasswordResetLinkController extends Controller
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RecoveryPasswordRequest $request): JsonResponse
    {
        $request = $request->validated();

        $user = User::where('email', $request['email'])
            ->first();

        if (empty($user)) {
            return response()->json([
                'valid' => false,
                'msg' => 'E-mail não existe na nossa base dados'
            ], 404);
        }

        $user->password_token_reset = Str::random(60);
        $user->save();

        SendMailRecoveryPassword::dispatch($user);

        return response()->json([
            'valid' => true,
            'msg' => 'E-mail para recuperação de senha enviado com sucesso'
        ]);
    }

    public function setNewPassword(RecoveryPasswordRequest $request)
    {

        $arrayRequest = $request->validated();
        $user = User::where('password_token_reset', $request['token'])->first();

        if (empty($user)) {
            throw ValidationException::withMessages([
                'token' => 'Token é inválido'
            ]);
        }

        if (Hash::check($arrayRequest['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'Senha não pode ser igual a senha anterior'
            ]);
        }

        $user->password = bcrypt($arrayRequest['password']);
        $user->save();

        return response()->json([
            'valid' => true,
            'msg' => 'Senha alterada com sucesso'
        ], 200);
    }
}
