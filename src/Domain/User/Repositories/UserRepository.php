<?php

namespace Domain\User\Repositories;

use Base\Concretes\BaseRepository;
use Domain\User\Contracts\Repositories\UserRepositoryInterface;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function findMail(string $email): Model|null
    {
        return $this->getBuilder()
            ->where('email', $email)
            ->first();
    }
}
