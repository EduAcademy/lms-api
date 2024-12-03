<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\Services\UserService;
use App\Shared\Handler\Result;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $userservice;

    public function __construct(UserService $userService)
    {
        $this->userservice = $userService;
    }

    public function register(SignUpRequest $request)
    {
        // Validation handled by SignUpRequest

        $user = $this->userservice->registerUser($request->validated());
        
        return Result::success($user, 'User registered successfully');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            "email" => "required|email|exists:users,email",
            "password" => "required|string"
        ]);

        $response = $this->userservice->login($data);
        return $response;
    }

    
    public function profile(Request $request)
    {
        $user = $request->user();
        
        return Result::success($user->role->name, 'Found profile Successfully', 200);
    }
}
