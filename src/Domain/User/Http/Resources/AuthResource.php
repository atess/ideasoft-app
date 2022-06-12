<?php

namespace Domain\User\Http\Resources;

use Base\Concretes\BaseJsonResource;
use Domain\User\Models\User;

/**
 * @property mixed $user
 * @property mixed $token
 */
class AuthResource extends BaseJsonResource
{
    public function __construct(public User   $user,
                                        public string $token)
    {
        parent::__construct([
            'user' => $this->user,
            'token' => $this->token,
        ]);
    }

    public function toArray($request): array
    {
        return [
            'status' => 'success',
            'message' => __('Token generated successfully.'),
            'data' => [
                'user' => UserResource::make($this->user),
                'token' => $this->token,
            ]
        ];
    }
}
