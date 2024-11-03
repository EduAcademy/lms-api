<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            "name"=>"required|string",
            "email"=>"required|email|unique:users",
            "password"=>"required|string"
        ]);
        $user = User::create($data);
        $token = $user->createToken("auth_token")->plainTextToken;
        return response()->json([
            "user"=>$user,
            "token"=>$token
        ]);
    }
    public function login(Request $request)
    {
        $data = $request->validate([
            "email"=>"required|email|exists:users",
            "password"=>"required|string"
        ]);
        $user = User::where("email",$data["email"])->first();
        if (!$user ||!Hash::check($data["password"],$user->password)) {
            return response()->json([
                "message"=>"Invalid credentials"
            ],401);
        }
        if (!auth()->attempt($data)) {
            return response()->json([
                "message"=>"Invalid credentials"
            ],401);
        }
        $token = $user->createToken("auth_token")->plainTextToken;
        return response()->json([
            "user"=>$user,
            "token"=>$token
        ]);
    }
}