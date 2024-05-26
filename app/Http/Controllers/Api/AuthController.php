<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:100',
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validations fails',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        $userData = $user->toArray();
        $userData['token'] = $token;

        return response()->json([
            'message' => 'Registration successful',
            'data' => $userData,
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validations fails',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {

            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('auth-token')->plainTextToken;

                $userData = $user->toArray();
                $userData['token'] = $token;
                return response()->json([
                    'message' => 'Login Successfull',
                    'data' => $userData,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Incorrect password',
                ], 400);
            }

        } else {
            return response()->json([
                'message' => 'User not found',
            ], 400);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'sometimes|min:6',
        ]);

        $user = Auth::user();

        // Update the username
        $user->username = $request->username;

        // Update the password if it's provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('status', 'Profile updated!');
    }
}