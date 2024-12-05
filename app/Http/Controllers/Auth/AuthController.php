<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\Services\UserService;
use App\Shared\Handler\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $userservice;

    public function __construct(UserService $userService)
    {
        $this->userservice = $userService;
    }

    public function register(SignUpRequest $request)
    {
        

        $response = $this->userservice->registerUser($request->all());
        return $response;
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
        
        return Result::success($user, 'Found profile Successfully', 200);
    }

    public function forgotPassword(Request $request)
    {
        $response = $this->userservice->forgotPassword($request->all());
        return $response;
    }

    public function resetPassword(Request $request)
    {
        $response = $this->userservice->resetPassword($request->all());
        return $response;
    }
}
