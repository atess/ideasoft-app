<?php

namespace Domain\User\DataTransferObjects;

use Base\Concretes\BaseData;
use Domain\User\Http\Requests\Auth\LoginRequest;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class LoginData extends BaseData
{
    public string $email;
    public string $password;
    public ?bool $remember;

    /**
     * @throws UnknownProperties
     */
    public static function fromLoginRequest(LoginRequest $request): self
    {
        return new self([
            'remember' => $request?->remember ?? false,
            'email' => $request->email,
            'password' => $request->password,
        ]);
    }
}
