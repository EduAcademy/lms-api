<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
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

    /**
     * @OA\Get(
     *      path="/users",
     *      tags={"Users"},
     *      summary="Get all users",
     *      description="Get list of all users",
     *      @OA\Response(response=200, description="Users retrieved Successfully")
     * )
     */
    public function index()
    {
        $result = $this->user_service->getAllUsers();

        // $result = User::search(request('search'))->get();

        // return response()->json($result);
        return $result;
    }


    public function register(SignUpRequest $request)
    {

        $data = $request->validated();
        $response = $this->user_service->registerUser($data); 
        return $response;
    }


    /**
     * @OA\Post(
     *      path="/login",
     *      tags={"Users"},
     *      summary="Signin endpoint",
     *      description="Signin a user by requiring email and password",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="email", type="string", maxLength=30, description="Email of user"),
     *              @OA\Property(property="password", type="string", maxLength=30, description="Password of user"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User is logged Successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string", description="JWT Token for user")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation failed",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", description="Error message"),
     *              @OA\Property(property="errors", type="object", description="Validation error details")
     *          )
     *      ),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Parameter(
     *          name="Accept",
     *          in="header",
     *          required=true,
     *          description="The Accept header for the request",
     *          @OA\Schema(type="string", default="application/json")
     *      )
     * )
     */

    public function login(SigninRequest $request)
    {
        $data = $request->validated();
        $response = $this->user_service->login($data);
        return $response;
    }


    public function profile(Request $request)
    {
        $user = $request->user();
        $result = $this->user_service->getUserProfile($user);
        return $result;
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

    public function patch($id, Request $request)
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

    public function show($id)
    {
        $result = $this->user_service->getUserById($id);

        return $result;
    }

    public function activateUser($id)
    {
        $result = $this->user_service->activateUser($id);

        return $result;
    }

    public function deactivateUser($id)
    {
        $result = $this->user_service->deactivateUser($id);

        return $result;
    }
}
