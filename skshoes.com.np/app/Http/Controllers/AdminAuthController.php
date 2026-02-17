<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api_token')->plainTextToken;
            return response()->json([
                            'token' => $token,
                            'user' => $user
                        ]);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return redirect()->route('admin.login');
    }
}
