<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken('api_access');

            return response()->json([
                'token' => $token->plainTextToken,
            ]);
        }

        return response()->json([
            'error' => 'Wrong credentials',
        ], 401);
    }
}
