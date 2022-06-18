<?php

namespace Domain\User\Contracts\Services;

use Base\Contracts\BaseServiceInterface;
use Domain\User\Contracts\Repositories;
use Illuminate\Database\Eloquent\Model;

interface UserServiceInterface extends BaseServiceInterface
{
    public function __construct(Repositories\UserRepositoryInterface $repository);

    public function findMail(string $email): Model|null;
}
