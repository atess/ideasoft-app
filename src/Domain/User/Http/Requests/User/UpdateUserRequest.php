<?php

namespace Domain\User\Http\Requests\User;

use Base\Concretes\BaseFormRequest;
use Domain\AppClient\Models\App;
use Domain\User\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * @property string $password
 * @property User $user
 */
class UpdateUserRequest extends BaseFormRequest
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
                Rule::unique('users')->ignore($this->user),
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(6)->letters()->symbols()->mixedCase(),
            ],
        ];
    }
}
