<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 
class UserLogin extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        Log::info('Login attempt with credentials: ' . json_encode($credentials));

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $credentials['email'])->first();
            $token = $user->createToken('myapptoken')->plainTextToken;

            Log::info('Login successful for user: ' . $user->email); 

            return response()->json(['message' => 'Login successful', 'token' => $token], 200);
        }

        Log::info('Login failed for email: ' . $credentials['email']); 

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}
