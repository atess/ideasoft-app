<?php

namespace Domain\User\Contracts\Repositories;

use Base\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findMail(string $email): Model|null;
}
