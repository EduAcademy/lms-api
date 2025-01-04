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
        $data = $request->validated();
        $response = $this->user_service->registerUser($data); // Pass validated data
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
        return $user;

        if ($user == null) {

            return Result::error('Token is expired or invalid', StatusResponse::HTTP_UNAUTHORIZED);
        }
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
        $result = $this->user_service->updateUser($id, $request->all());

        return $result;
    }

    public function delete($id)
    {
        $result = $this->user_service->deleteUser($id);

        return $result;
    }

    public function validateToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);


        $result = $this->user_service->validateToken($request->token);

        return $result;
    }

    public function logout(Request $request)
    {
        $result = $this->user_service->logout($request->user());

        return $result;
    }

    public function refreshToken(Request $request)
    {
        $data = $request->validate([
            'refresh_token' => 'required|string',
        ]);

        $response = $this->user_service->refreshAccessToken($data['refresh_token']);
        return $response;
    }
}
