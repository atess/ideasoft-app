<?php

namespace Domain\User\Repositories\Contracts;

use Base\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findMail(string $email): Model|null;
}
