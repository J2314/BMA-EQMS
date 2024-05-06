<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class UserController extends Controller
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

            return response()->json(['message' => 'Login successful', 'user' => $user, 'token' => $token], 200);
        }

        Log::info('Login failed for email: ' . $credentials['email']);

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'department_id' => 'required',
            'role' => 'required',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    
        $role = Role::create([
            'department_id' => $request->department_id,
            'user_id' => $user->id,
            'role' => $request->role,
        ]);
    
        return response()->json(['message' => 'User registered successfully'], 200);
    }
    

public function getUsers()
{
    try {
        $users = User::all();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No users found'], 404);
        }

        $usersWithDetails = [];
        foreach ($users as $user) {
            $role = Role::where('user_id', $user->id)->first();
            if ($role) {
                $department = $role->department_id; 
                $roleName = $role->role; 
            } else {
                $department = null;
                $roleName = null;
            }

            $usersWithDetails[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'department_id' => $department,
                'role' => $roleName,
            ];
        }

        return response()->json(['users' => $usersWithDetails], 200);
    } catch (ThrottleRequestsException $e) {
        return response()->json(['error' => 'Too many requests. Please try again later.'], 429);
    }
}
}
