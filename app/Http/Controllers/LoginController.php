<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $password = $request->input('password');
        $email = $request->input('email');

        $loged = Auth::attempt(['email' => $email, 'password' => $password]);
        if ($loged) {
            $user = User::where('email', $email)->with('role')->first();

            $token = $user->createToken('TOKEN');
            return response()->json(['user' => $user, 'token' => $token->plainTextToken]);
        } else {
            return response()->json(['message' => 'UNAUTHORIZED'], Response::HTTP_UNAUTHORIZED);
        }
    }
}
