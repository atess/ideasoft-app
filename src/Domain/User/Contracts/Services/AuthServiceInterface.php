<?php

namespace Domain\User\Contracts\Services;

use Domain\User\DataTransferObjects\LoginData;
use Domain\User\DataTransferObjects\RegisterData;

interface AuthServiceInterface
{
    public function __construct(UserServiceInterface $userService);

    public function login(LoginData $loginData): array;

    public function register(RegisterData $registerData): array;
}
