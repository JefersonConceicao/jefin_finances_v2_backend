<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UsersController extends Controller
{
    public function profile()
    {
        return response()->json(Auth::user(), 200);
    }

    public function updateProfile(Request $request){
        try{

            $request->validate([
                'email' => 'required|email',
                'name' => 'required',
                'last_name' => 'required',
            ]);

            $user = User::find(Auth::user()->id);
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;

            $user->save();

            return response()->json([
                'error' => false,
                'data' => $user
            ], 200);

        }catch(Exception $error){
            return response()->json([
                'error' => true,
                'msg' => 'Ocorreu um erro interno!',
                'error_message' => $error->getMessage()
            ], 500);
        }
    }
}
