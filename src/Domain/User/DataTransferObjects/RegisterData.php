<?php

namespace Domain\User\DataTransferObjects;

use Base\Concretes\BaseData;
use Domain\User\Http\Requests\Auth\RegisterRequest;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class RegisterData extends BaseData
{
    public string $name;
    public string $email;
    public string $password;
    public bool $remember;

    /**
     * @throws UnknownProperties
     */
    public static function fromRegisterRequest(RegisterRequest $request): self
    {
        return new self([
            'name' => $request->name,
            'remember' => $request->remember ?? false,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    }
}
