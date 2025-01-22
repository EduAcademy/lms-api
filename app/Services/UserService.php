<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use App\Enums\RoleType;
use App\Http\Requests\SigninRequest;
use App\Interfaces\Services\InstructorServiceInterface;
use App\Interfaces\Services\StudentServiceInterface;
use App\Interfaces\Services\UserServiceInterface;
use App\Models\User;
use App\Repositories\GenericRepository;
use App\Http\Requests\SignUpRequest;
use App\Mail\EmailSender;
use App\Shared\Constants\MessageResponse;
use App\Shared\Constants\StatusResponse;
use App\Shared\Handler\Result;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Exceptions\LmsExceptionsTrait;



class UserService implements UserServiceInterface
{
    use LmsExceptionsTrait;
    protected $userRepository;
    protected $studentService;
    // protected $instructorService;
    private $genericRepository;
    private $roleService;
    public function __construct(
        UserRepositoryInterface $userRepository,
        StudentServiceInterface $studentService,
        // InstructorServiceInterface $instructorService,
        RoleService $roleService
    ) {
        $this->userRepository = $userRepository;
        $this->genericRepository = new GenericRepository(new User);
        $this->studentService = $studentService;
        // $this->instructorService = $instructorService;
        $this->roleService = $roleService;
    }

    public function getAllUsers()
    {
        // try {

            $result = $this->userRepository->getAll();

            return Result::success($result, MessageResponse::RETRIEVED_SUCCESSFULLY, StatusResponse::HTTP_OK);
        // } catch (QueryException $queryException) {
            // return $this->queryExceptionResponse($queryException);
        // }
    }

    public function getUserById($id)
    {

        $result = $this->userRepository->getById($id);

        if (!$result) {
            return Result::error(MessageResponse::NO_QUERY_RESULTS, StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success($result, MessageResponse::FETCHED_SUCCESSFULLY, StatusResponse::HTTP_OK);
    }
    public function isRoleAllowed($userId, $allowedRole)
    {
        $user = $this->userRepository->getById($userId);

        return $user->role->name == $allowedRole ? true : false;
    }

    public function getUserByEmail($email)
    {
        return $this->userRepository->getByEmail($email);
    }

    public function registerUser(array $data)
    {
        try {
            $validator = Validator::make($data, (new SignUpRequest())->rules());

            if ($validator->fails()) {
                return Result::error(MessageResponse::VALIDATION_FAILED, 422, $validator->errors());
            }

            $data['password'] = Hash::make($data['password']);

            $role = $this->roleService->getRoleByName(RoleType::Student);
            $data['role_id'] = $data['role_id'] ?? $role;

            $result = $this->userRepository->create($data);

            if (!$result) {
                return Result::error(MessageResponse::INTERNAL_SERVER_ERROR_MESSAGE, 500);
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

            return Result::success($result, MessageResponse::CREATED_SUCCESSFULLY, 200);
        } catch (Exception $ex) {
            return Result::error($ex, StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function generateTokens($user)
    {
        $accessToken = $user->createToken('auth_token', ['*'], now()->addHours(24))->plainTextToken;

        // Generate refresh token
        $refreshToken = bin2hex(random_bytes(40));
        $refreshTokenExpiresAt = now()->addDays(7);

        // Retrieve the newly created token
        $personalAccessToken = $user->tokens()->latest('id')->first();


        if ($personalAccessToken) {
            $personalAccessToken->update([
                'refresh_token' => $refreshToken,
                'refresh_token_expires_at' => $refreshTokenExpiresAt,
            ]);
        }

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'expires_in' => 24 * 60 * 60, // Access token expiry in seconds
        ];
    }


    public function login(array $data)
    {

        $validator = Validator::make($data, (new SigninRequest())->rules());

        if ($validator->fails()) {
            return Result::error(MessageResponse::VALIDATION_FAILED, StatusResponse::HTTP_UNPROCESSABLE_ENTITY, $validator->errors());
        }


        if (!auth()->attempt($data)) {
            return Result::error(MessageResponse::INVALID_USER, StatusResponse::HTTP_UNAUTHORIZED);
        }

        $user = auth()->user();

        if (!$user->is_active) {
            return Result::error(MessageResponse::USER_NOT_ACTIVATED, StatusResponse::HTTP_BAD_REQUEST);
        }

        $tokens = $this->generateTokens($user);

        return Result::success_with_token($user, $tokens, MessageResponse::LOGIN_SUCCESSFUL, 200);
    }


    public function refreshAccessToken($refreshToken)
    {
        $tokenRecord = PersonalAccessToken::whereHas('refresh_token', $refreshToken)
            ->where('refresh_token_expires_at', '>', now())
            ->first();

        if (!$tokenRecord) {
            return Result::error(MessageResponse::INVALID_TOKEN, 401);
        }

        $user = $tokenRecord->tokenable;

        // Generate new tokens
        $newTokens = $this->generateTokens($user);

        // Delete the old token to avoid reuse
        $tokenRecord->delete();

        return Result::success($newTokens, 'Token refreshed successfully', 200);
    }
    public function updateUser($id, array $data)
    {
        try {

            $validator = Validator::make($data, [
                'username' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'phone' => 'nullable|string',
            ]);


            if ($validator->fails()) {
                return Result::error(MessageResponse::VALIDATION_FAILED, StatusResponse::HTTP_UNPROCESSABLE_ENTITY, $validator->errors());
            }

            $result = $this->genericRepository->update($id, $data);

            if (!$result) {
                return Result::error(MessageResponse::INTERNAL_SERVER_ERROR_MESSAGE, StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
            }

            return Result::success($result, MessageResponse::UPDATED_SUCCESSFULLY, StatusResponse::HTTP_OK);
        } catch (Exception $ex) {

            return Result::error($ex->getMessage(), StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deleteUser($id)
    {
        $result = $this->genericRepository->delete($id);

        if (!$result) {
            return Result::error(MessageResponse::INTERNAL_SERVER_ERROR_MESSAGE, StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
        return Result::success($result, MessageResponse::DELETED_SUCCESSFULLY, StatusResponse::HTTP_OK);
    }

    public function forgotPassword(array $data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return Result::error(MessageResponse::VALIDATION_FAILED, StatusResponse::HTTP_UNPROCESSABLE_ENTITY, $validator->errors());
        }

        $status = Password::sendResetLink($data, function ($user, $token) use ($data) {
            $resetUrl = url('/reset-password?token=' . $token . '&email=' . urlencode($data['email']));

            Log::info($resetUrl);
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
            return Result::error(MessageResponse::VALIDATION_FAILED, StatusResponse::HTTP_UNPROCESSABLE_ENTITY, $validator->errors());
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
            return Result::success(null, MessageResponse::LOGGED_OUT_SUCCESSFULLY, StatusResponse::HTTP_OK);
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
            return Result::error(MessageResponse::INVALID_TOKEN, StatusResponse::HTTP_BAD_REQUEST);
        }

        // Check if the token is expired
        if ($accessToken->expires_at && $accessToken->expires_at->isPast()) {
            return Result::error(MessageResponse::INVALID_TOKEN, StatusResponse::HTTP_NOT_FOUND);
        }

        return Result::success(MessageResponse::INVALID_TOKEN, StatusResponse::HTTP_OK);
    }

    public function activateUser($userId)
    {
        $result = $this->userRepository->activate($userId);

        if (!$result) {
            return Result::error(MessageResponse::INTERNAL_SERVER_ERROR_MESSAGE, StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Result::success($result, 'User is activated Successfully');
    }


    public function deactivateUser($userId)
    {
        $result = $this->userRepository->deactivate($userId);

        if (!$result) {
            return Result::error(MessageResponse::INTERNAL_SERVER_ERROR_MESSAGE, StatusResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return Result::success($result, 'User is deactivated Successfully');
    }
}
