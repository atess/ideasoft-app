<?php

namespace Domain\User\Http\Requests\User;

use Base\Concretes\BaseFormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * @property string $email
 * @property string $password
 * @property int $app
 * @property mixed $name
 */
class StoreUserRequest extends BaseFormRequest
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
