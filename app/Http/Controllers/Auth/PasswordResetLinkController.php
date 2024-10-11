<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RecoveryPasswordRequest;
use App\Mail\RecoveryPassword;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
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

        if(empty($user)){
            return response()->json([
                'valid' => false,
                'msg' => 'E-mail não existe na nossa base dados'
            ], 404);
        }

        $user->password_token_reset = Str::random(60);
        $user->save();

        dd(Mail::to('jefersonmallone2000@outlook.com')->send(new RecoveryPassword($user)));

        return response()->json([
            'valid' => true,
            'msg' => 'E-mail para recuperação de senha enviado com sucesso'
        ]);
    }
}
