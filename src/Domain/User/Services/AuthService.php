<?php

namespace Domain\User\Services;

use Domain\User\DataTransferObjects\LoginData;
use Domain\User\DataTransferObjects\RegisterData;
use Domain\User\Services\Contracts\AuthServiceInterface;
use Domain\User\Services\Contracts\UserServiceInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;

class AuthService implements AuthServiceInterface
{
    public function __construct(protected UserServiceInterface $userService)
    {
    }

    /**
     * @param LoginData $loginData
     * @return array
     * @throws AuthenticationException
     */
    public function login(LoginData $loginData): array
    {
        $user = $this->userService->findMail($loginData->email);

        if (!$user || !Hash::check($loginData->password, $user?->password)) {
            throw new AuthenticationException(__('Email or password is incorrect'));
        }

        if ($loginData->remember) {
            Passport::personalAccessTokensExpireIn(now()->addMonths(6));
        }

        return [
            'user' => $user,
            'token' => $user->createToken('token')->accessToken
        ];
    }

    /**
     * @param RegisterData $registerData
     * @return array
     */
    public function register(RegisterData $registerData): array
    {
        $user = $this->userService->store($registerData);

        return [
            'user' => $user,
            'token' => $user->createToken('token')->accessToken
        ];
    }
}
