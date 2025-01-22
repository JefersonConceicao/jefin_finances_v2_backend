<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class APIAuthController extends Controller
{
    public function authenticate(LoginRequest $request)
    {
        $credentials = (object)$request->validated();
        $user = User::where('email', $credentials->email)->first();

        if (!$user || !Hash::check($credentials->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Credenciais incorretas'
            ]);
        }

        $generateTokenSanctum = $user->createToken(
            'auth_token',
            ['*'],
            now()->addWeek()
        );

        if (!empty($generateTokenSanctum)) {
            $user->last_login = now()->toDateTimeString();
            $user->save();
        }

        return response()->json([
            'error' => false,
            'access_token' => $generateTokenSanctum->plainTextToken,
            'expiration' => $generateTokenSanctum->accessToken->expires_at,
            'user' => $user
        ], 200);
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->tokens()->delete();

            return response()->json([
                'error' => false,
            ], 200);
        }

        return response()->json([
            'error' => true,
            'message' => 'Usuário não autenticado'
        ], 401);
    }
}
