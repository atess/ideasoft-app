<?php

namespace Domain\User\DataTransferObjects;

use Base\Concretes\BaseData;
use Domain\User\Http\Requests\User\StoreUserRequest;
use Domain\User\Http\Requests\User\UpdateUserRequest;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class UserData extends BaseData
{
    public string $name;
    public string $email;
    public string $password;

    /**
     * @param StoreUserRequest $request
     * @return static
     * @throws UnknownProperties
     */
    public static function fromStoreRequest(StoreUserRequest $request): self
    {
        return new self([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    }

    /**
     * @param UpdateUserRequest $request
     * @return static
     * @throws UnknownProperties
     */
    public static function fromUpdateRequest(UpdateUserRequest $request): self
    {
        $data = $request->validated();

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        return new self($data);
    }
}
