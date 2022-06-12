<?php

namespace Domain\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Domain\User\DataTransferObjects\LoginData;
use Domain\User\DataTransferObjects\RegisterData;
use Domain\User\Http\Requests\Auth\LoginRequest;
use Domain\User\Http\Requests\Auth\RegisterRequest;
use Domain\User\Http\Resources\AuthResource;
use Domain\User\Http\Resources\UserResource;
use Domain\User\Services\Contracts\AuthServiceInterface;
use Domain\User\Services\Contracts\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AuthController extends Controller
{
    public function __construct(protected UserServiceInterface $userService,
                                protected AuthServiceInterface $authService)
    {
    }

    /**
     * @param LoginRequest $request
     * @return AuthResource
     * @throws UnknownProperties
     */
    public function login(LoginRequest $request): AuthResource
    {
        $attempt = $this->authService->login(LoginData::fromLoginRequest($request));

        return AuthResource::make(
            $attempt['user'],
            $attempt['token'],
        );
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $attempt = $this->authService->register(RegisterData::fromRegisterRequest($request));

        return AuthResource::make(
            $attempt['user'],
            $attempt['token'],
        )
            ->response()
            ->setStatusCode(201);
    }

    /**
     * @return Response
     */
    public function logout(): Response
    {
        Auth::user()->token()->revoke();
        return response()->noContent();
    }

    /**
     * @return UserResource
     */
    public function me(): UserResource
    {
        return UserResource::make(
            $this->userService->queryFindOrFail(Auth::id()),
        );
    }
}
