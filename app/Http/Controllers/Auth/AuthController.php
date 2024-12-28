<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\Services\UserService;
use App\Shared\Handler\Result;
use Illuminate\Http\Request;

use App\Shared\Constants\StatusResponse;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    private $user_service;

    public function __construct(UserService $userService)
    {
        $this->user_service = $userService;
    }

    public function index()
    {
        $result = $this->user_service->getAllUsers();

        return $result;
    }

    public function register(SignUpRequest $request)
    {
        $response = $this->user_service->registerUser($request->all());
        return $response;
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            "email" => "required|email|exists:users,email",
            "password" => "required|string"
        ]);

        $response = $this->user_service->login($data);
        return $response;
    }


    public function profile(Request $request)
    {
        $user = $request->user();



        return Result::success($user, 'Found profile Successfully', StatusResponse::HTTP_OK);
    }

    public function forgotPassword(Request $request)
    {
        $response = $this->user_service->forgotPassword($request->all());
        return $response;
    }

    public function resetPassword(Request $request)
    {
        $response = $this->user_service->resetPassword($request->all());
        return $response;
    }

    public function update($id, Request $request)
    {

    }

    public function delete($id)
    {

    }

    public function validateToken(Request $request)
    {
        // Validate the token input
        $data = $request->validate([
            'token' => 'required|string',
        ]);

        // Call the service method to validate the token
        $response = $this->user_service->validateToken($data['token']);

        return response()->json($response);
    }
}
