<?php

namespace Domain\User\Http\Controllers;

use Base\Concretes\BaseController;
use Domain\User\Contracts\Services\UserServiceInterface;
use Domain\User\DataTransferObjects\UserData;
use Domain\User\Http\Requests\User\IndexUserRequest;
use Domain\User\Http\Requests\User\StoreUserRequest;
use Domain\User\Http\Requests\User\UpdateUserRequest;
use Domain\User\Http\Resources\UserResource;
use Domain\User\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use function response;

class UserController extends BaseController
{
    public function __construct(public UserServiceInterface $userService)
    {
    }

    /**
     * @param IndexUserRequest $request
     * @return JsonResource
     */
    public function index(IndexUserRequest $request): JsonResource
    {
        return UserResource::collection(
            $this->userService->queryPaginate()
        );
    }

    /**
     * @param StoreUserRequest $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        return UserResource::make(
            $this->userService->store(
                UserData::fromStoreRequest($request)
            )
        )
            ->response()
            ->setStatusCode(201);
    }

    /**
     * @param int $userId
     * @return UserResource
     */
    public function show(int $userId): UserResource
    {
        return UserResource::make(
            $this->userService->queryFindOrFail($userId)
        );
    }

    /**
     * @param User $user
     * @param UpdateUserRequest $request
     * @return UserResource
     */
    public function update(User $user, UpdateUserRequest $request): UserResource
    {
        return UserResource::make(
            $this->userService->update($user,
                UserData::fromUpdateRequest($request)
            )
        );
    }

    /**
     * @param User $user
     * @return Response
     */
    public function destroy(User $user): Response
    {
        $this->userService->destroy($user);
        return response()->noContent();
    }
}
