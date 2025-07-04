<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
        ]);

        // Create the user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'address' => $validatedData['address'],
            'phone' => $validatedData['phone'],
        ]);

        // Return a success response
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        // Validate the request data
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check user
        $user = User::where('email', $validate['email'])->first();
        if (!$user || !Hash::check($validate['password'], $user->password))
        {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);  
        }

        // Generate a token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return a success response with the token
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ], 200);   
    }

    public function logout(Request $request)
    {
        // Revoke the user's token
        $request->user()->currentAccessToken()->delete();

        // Return a success response
        return response()->json([
            'message' => 'Logout successful',
        ], 200);
    }

    public function show($id){
        // Find the user by ID
        $user = User::find($id);

        // Check if user exists
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        // Return the user data
        return response()->json([
            'user' => $user,
        ], 200);
    }
}
