<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use App\Enums\RoleType;
use App\Interfaces\Services\InstructorServiceInterface;
use App\Interfaces\Services\StudentServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Models\User;
use App\Repositories\GenericRepository;
use App\Http\Requests\SignUpRequest;
use App\Mail\EmailSender;
use App\Models\Role;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class UserService implements UserServiceInterface
{
    protected $userRepository;
    protected $studentService;
    protected $instructorService;
    private $genericRepository;
    private $roleService;
    public function __construct(
        UserRepositoryInterface $userRepository,
        StudentServiceInterface $studentService,
        InstructorServiceInterface $instructorService,
        RoleService $roleService
    ) {
        $this->userRepository = $userRepository;
        $this->genericRepository = new GenericRepository(new User);
        $this->studentService = $studentService;
        $this->instructorService = $instructorService;
        $this->roleService = $roleService;
    }

    public function getAllUsers()
    {
        $result = $this->userRepository->getAll();

        return Result::success($result, 'Get All Users Successfully', StatusResponse::HTTP_OK);
    }

    public function getUserById($id)
    {
        return $this->userRepository->getById($id);
    }

    public function getUserByEmail($email)
    {
        return $this->userRepository->getByEmail($email);
    }

    public function registerUser(array $data)
    {

        $validator = Validator::make($data, (new SignUpRequest())->rules());

        if ($validator->fails()) {
            return Result::error('Validation failed', 422, $validator->errors());
        }

        $data['password'] = Hash::make($data['password']);
        $role = $this->roleService->getRoleByName(RoleType::Student);
        $data['role_id'] = $data['role_id'] ?? $role;

        $result = $this->userRepository->create($data);

        if (!$result) {
            return Result::error('Failed to create user', 500);
        }

        // $user = $this->userRepository->findById($result->id);

        // if($user){
        //     return Result::success($user->role->name, 'User found bla', 200);
        // }
        // if ($user->role->name == RoleType::Student) {
        //     // $result = $this->studentService->createStudent();
        // }

        // if ($user->role->name == RoleType::Instructor) {
        //     // $result = $this->instructorService->createInstructor();
        // }

        return Result::success($result, 'User registered successfully', 200);
    }

    public function login(array $data)
    {

        if (!auth()->attempt($data)) {
            return Result::error('Invalid credentials', 401);
        }

        $user = auth()->user();
        $token = $user->createToken("auth_token", ['*'], now()->addHours(24))->plainTextToken;


        return Result::success_with_token($user, $token, 'Logged in successfully', 200);
    }

    public function updateUser($id, array $data)
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

    public function deleteUser($id)
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

        // Generate the reset token
        $status = Password::sendResetLink($data, function ($user, $token) use ($data) {
            $resetUrl = url('/reset-password?token=' . $token . '&email=' . urlencode($data['email']));

            Log::info($resetUrl);
            // Send custom email
            Mail::to($data['email'])->send(new EmailSender($resetUrl));
        });

        return $status === Password::RESET_LINK_SENT
            ? Result::success([], __('A password reset link has been sent to your email address.'))
            : Result::error(__('Unable to send reset link.'), 400);
    }

    public function resetPassword(array $data)
    {
        $validator = Validator::make($data, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
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
            : Result::error(__($status), StatusResponse::HTTP_BAD_REQUEST);
    }


    public function logout($user)
    {
        // Revoke current token
        try {
            $user->currentAccessToken()->delete();
            return Result::success(null, 'Logged out successfully', StatusResponse::HTTP_OK);
        } catch (\Exception $e) {
            return Result::error("Logout failed: . {$e}", StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
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
        return Result::success('The token is valid', StatusResponse::HTTP_OK);
    }
}
