<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use App\Interfaces\Services\InstructorServiceInterface;
use App\Interfaces\Services\StudentServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Models\User;
use App\Repositories\GenericRepository;
use App\Shared\Constants\RoleEnum;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class UserService implements UserServiceInterface
{
    protected $userRepository;
    protected $studentService;
    protected $instructorService;
    private $genericRepository;
    public function __construct(
        UserRepositoryInterface $userRepository,
        StudentServiceInterface $studentService,
        InstructorServiceInterface $instructorService
    ) {
        $this->userRepository = $userRepository;
        $this->genericRepository = new GenericRepository(new User);
        $this->studentService = $studentService;
        $this->instructorService = $instructorService;
    }

    public function getAllUsers()
    {
        // $result = $this->userRepository->getAll();

        return;
        // return Result::success($result, 'Get All Users Successfully', StatusResponse::HTTP_OK);
    }

    public function getUserById($id)
    {
        return $this->userRepository->findById($id);
    }

    public function getUserByEmail($email)
    {
        return $this->userRepository->findByEmail($email);
    }

    public function registerUser(array $data)
    {

        $validator = Validator::make($data, [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'role_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $data['password'] = Hash::make($data['password']);
        $data['role_id'] = $data['role_id'] ?? 3;

        $result = $this->userRepository->createUser($data);

        $user = $this->userRepository->findById($result->id);


        if ($user->role->name == RoleEnum::Student) {
            $result = $this->studentService->createStudent();
        }

        if ($user->role->name == RoleEnum::Instructor) {
            $result = $this->instructorService->createInstructor();
        }

        return Result::success($user, 'User registered successfully', 200);
    }

    public function login(array $data)
    {

        // if (!$user) {
        //     return Result::error('Username or password is invalid', 401);
        // }

        if (!auth()->attempt($data)) {
            return Result::error('Invalid credentials', 401);
        }

        $user = auth()->user();
        $token = $user->createToken("auth_token", ['*'], now()->addHours(24))->plainTextToken;


        return Result::success_with_token($user, $token, 'Logged in successfully', 200);
    }

    public function update($id, array $data)
    {
        $validator = Validator::make($data, [
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'role_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }


        $result = $this->genericRepository->update($id, $data);

        return Result::success($result, 'User is updated Successfully', StatusResponse::HTTP_OK);
    }

    public function delete($id)
    {
        $result = $this->genericRepository->delete($id);

        return Result::success($result, 'User is deleted Successfully', StatusResponse::HTTP_OK);
    }

    public function forgotPassword(array $data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $status = Password::sendResetLink($data);

        return $status === Password::RESET_LINK_SENT
            ? Result::success([], __($status))
            : Result::error(__($status), 400);
    }

    public function resetPassword(array $data)
    {
        $validator = Validator::make($data, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $status = Password::reset(
            $data,
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                $user->tokens()->delete();
                $user->createToken('auth_token')->plainTextToken;
            }
        );

        return $status === Password::PASSWORD_RESET
            ? Result::success([], __($status))
            : Result::error(__($status), 400);
    }

    public function validateToken(string $token)
    {
        // Parse the token to retrieve the token model
        $accessToken = PersonalAccessToken::findToken($token);

        // If no token found, return invalid response
        if (!$accessToken) {
            return Result::error('The token is invalid or not found.', StatusResponse::HTTP_BAD_REQUEST);
        }

        // Check if the token is expired
        if ($accessToken->expires_at && $accessToken->expires_at->isPast()) {
            return Result::error('The token is invalid or not found.', StatusResponse::HTTP_NOT_FOUND);
        }

        // Token is valid
        return Result::success('The token is invalid or not found.', StatusResponse::HTTP_OK);
    }
}
