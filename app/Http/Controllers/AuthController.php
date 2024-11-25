<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\SingUpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup(SingUpRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'token' => $token,
            'user' => $user
        ]);
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = $request->boolean('remember') ?? false;
        unset($credentials['remember']);

        if (!Auth::attempt($credentials, $remember)) {
            return response([
                'message' => 'The provided credentials are incorrect.'
            ], 422);
        }

        // $user = User::where('email', $credentials['email'])->first();
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        // Revoke the token that was used to authenticate the current request...
        $user->currentAccessToken()->delete();
        return response([
            'success' => true,
            'message' => 'Logout successfully'
        ]);
    }

    public function contact()
    {
        return response()->json([
            'message' => 'hello world'
        ]);
    }
}
