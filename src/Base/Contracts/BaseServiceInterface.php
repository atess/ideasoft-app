<?php

namespace Base\Contracts;

use Base\Concretes\BaseData;
use Base\Concretes\BaseQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseServiceInterface
{
    public function paginate(array $conditions = [], int $perPage = 10, array $with = [], array $columns = ['*']): Collection|LengthAwarePaginator;

    public function queryPaginate(array $conditions = [], int $perPage = 10, array $with = [], array $columns = ['*']): Collection|LengthAwarePaginator;

    public function get(array $conditions = [], array $with = [], array $columns = ['*']): Collection|LengthAwarePaginator;

    public function queryGet(array $conditions = [], array $with = [], array $columns = ['*']): Collection|LengthAwarePaginator;

    public function getOrPaginate(array $conditions = [], int $perPage = 10, array $with = [], array $columns = ['*']): Collection|LengthAwarePaginator;

    public function queryGetOrPaginate(array $conditions = [], int $perPage = 10, array $with = [], array $columns = ['*']): Collection|LengthAwarePaginator;

    public function first(array $conditions = [], array $with = []): Model|null;

    public function firstOrFail(array $conditions = [], array $with = []): Model;

    public function updateOrCreate(array $attributes, array $values = []): Model|static;

    public function queryFindOrFail(int $modelId, bool $unsetWheres = true): Model;

    public function findFromMixed(Model|int|string $model, ?string $key = null): Model;

    public function update(Model $model, BaseData $baseData, bool $unsetWheres = true): Model;

    public function store(BaseData $baseData, bool $unsetWheres = true): Model;

    public function exists(array $conditions = []): bool;

    public function findOrFail(int $modelId): Model;

    public function destroy(Model $model): bool;

    public function repository(): BaseRepositoryInterface;

    public function query(): BaseQuery;
}
