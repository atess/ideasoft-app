<?php

namespace Domain\User\Services\Contracts;

use Base\Contracts\BaseServiceInterface;
use Domain\User\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface UserServiceInterface extends BaseServiceInterface
{
    public function __construct(UserRepositoryInterface $repository);

    public function findMail(string $email): Model|null;
}
