<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RefreshTokenRequest;
use App\Http\Resources\UserResource;
use Core\Repositories\Interfaces\UserRepositoryContract;
use Core\Services\SanctumRefreshToken\PersonalAccessToken;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends ApiController
{
    protected $userRepository;

    public function __construct(UserRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * API login with email
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request) {
        $user = $this->userRepository->findByField('email', $request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->responseError(__('messages.login_fail'), Response::HTTP_UNAUTHORIZED);
        }

        // Create new AccessToken
        $token = $user->createToken($user->name);

        return $this->responseSuccess([
            'user' => new UserResource($user),
            'access_token' => $token->plainTextToken,
            'refresh_token' => $token->plainTextRefreshToken,
            'expired_at' => $token->expiredAt,
        ]);
    }

    /**
     * Get new token by refresh token
     */
    public function refreshToken(RefreshTokenRequest $request) {
        $token = PersonalAccessToken::findRefreshToken($request->refresh_token);
        
        if (!$token) {
            return $this->responseError(__('messages.refresh_token_not_exists'));
        }

        if (!$token->isValidRefreshToken()) {
            return $this->responseError(__('messages.refresh_token_expired'));
        }

        $user = $token->tokenable;
    }
}
