<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function Register (RegisterRequest $request){
      $user=User::create(
        [
            'name' => $request->name,
            'email' => $request->email,
            'password' =>bcrypt($request->password)
        ]);
    $token = $user->createToken('api-token')->plainTextToken;
            return response()->json([
                'user' => new UserResource($user),
                'token' => $token
            ], 201);
      
    

    }

    public function login(Request $request){
        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'user' => new UserResource($user),
            'token' => $token
        ], 200);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
