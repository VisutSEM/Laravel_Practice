<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('myapp')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);

    
    }

    public function login(LoginRequest $request)
    {
        $request->validated();

        $user = User::whereUsername($request->username)->first(); 
        if(!$user || !Hash::check($request->password, $user->password)){
            return response([
                'message' => 'invaidcredential'
            ],422);
        }

        $token = $user->createToken('myapp')->plainTextToken;   
        return response()->json([
            'user' => $user,
            'token' => $token
        ], 201);
    }
}
