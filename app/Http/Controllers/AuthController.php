<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->accessToken;
            // dd($token);
            // Redirigi alla pagina home con il token
            return view('home', ['token' => $token]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request) { if ($request->user() && $request->user()->token()) { $request->user()->token()->revoke(); return response()->json(['message' => 'Successfully logged out']); } else { return response()->json(['error' => 'User not authenticated'], 401); } }
    
}