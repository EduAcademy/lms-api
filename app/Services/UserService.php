<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
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

        $user = $this->userRepository->createUser($data);

        return Result::success($user, 'User registered successfully', 200);
    }

    public function login(array $data)
    {
        if (!auth()->attempt($data)) {
            return Result::error('Invalid credentials', 401);
        }

        $user = auth()->user();
        $token = $user->createToken("auth_token")->plainTextToken;

        return Result::success_with_token($user, $token, 'Logged in successfully', 200);
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
}
