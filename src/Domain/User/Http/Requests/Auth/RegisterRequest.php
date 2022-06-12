<?php

namespace Domain\User\Http\Requests\Auth;

use Base\Concretes\BaseFormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * @property string $email
 * @property string $password
 * @property bool $remember
 * @property mixed $name
 */
class RegisterRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'max:50',
            ],
            'remember' => [
                'nullable',
                'boolean',
            ],
            'email' => [
                'required',
                'email:filter',
                'unique:users',
                'max:100',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(6)->letters()->symbols()->mixedCase(),
            ],
        ];
    }
}
