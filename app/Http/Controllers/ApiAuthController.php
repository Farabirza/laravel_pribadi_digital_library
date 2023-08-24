<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\LoginResource;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class ApiAuthController extends Controller
{
    public function users()
    {
        return response()->json([
            'user' => User::get(),
        ], 200);
    }
    // register
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('token')->plainTextToken;
        return new LoginResource([
            'token' => $token,
            'user' => $user
        ]);
    }

    // login
    public function login(LoginRequest $request)
    {
        if(Auth::attempt($request->only('email', 'password'))) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('token')->plainTextToken;
            return new LoginResource([
                'token' => $token,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'message' => "Invalid credentials",
            ]);
        }
        // if(!$user || !Hash::check($request->password, $user->password)) {
        //     return response()->json([
        //         'message' => "Bad credentials"
        //     ], 404);
        // }
        // $token = $user->createToken('token')->plainTextToken;
    }

    // logout
    public function logout(Request $request)
    {
        // $request->user()->currentAccessToken()->delete();
        $request->user()->tokens()->delete();
        return response()->noContent();
    }
}
