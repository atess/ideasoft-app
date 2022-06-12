<?php

namespace Domain\User\Http\Requests\Auth;

use Base\Concretes\BaseFormRequest;

/**
 * @property string $email
 * @property string $password
 * @property bool $remember
 */
class LoginRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:100'],
            'password' => ['required', 'max:50'],
            'remember' => ['nullable', 'boolean'],
        ];
    }
}
