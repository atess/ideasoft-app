<?php

namespace Domain\User\Services;

use Base\Concretes\BaseData;
use Base\Concretes\BaseQuery;
use Base\Concretes\BaseService;
use Domain\User\Queries\UserQuery;
use Domain\User\Repositories\Contracts\UserRepositoryInterface;
use Domain\User\Services\Contracts\UserServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService implements UserServiceInterface
{
    public function __construct(protected UserRepositoryInterface $repository)
    {
    }

    public function store(BaseData $baseData, ?bool $unsetWheres = true): Model
    {
        try {
            DB::beginTransaction();

            $user = $this->repository()->store($baseData->onlyFilled()->toArray(), $this->query(), $unsetWheres);

            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();

            throw $exception;
        }

        return $user;
    }

    public function update(Model $model, BaseData $baseData, ?bool $unsetWheres = true): Model
    {
        try {
            DB::beginTransaction();

            $user = $this->repository()->update($model, $baseData->onlyFilled()->toArray(), $this->query(), $unsetWheres);

            DB::commit();
        } catch (QueryException $exception) {
            DB::rollBack();

            throw $exception;
        }

        return $user;
    }

    public function findMail(string $email): Model|null
    {
        return $this->repository()->findMail($email);
    }

    public function repository(): UserRepositoryInterface
    {
        return $this->repository;
    }

    public function query(): BaseQuery
    {
        return new UserQuery();
    }
}
