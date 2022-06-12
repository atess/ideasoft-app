<?php

namespace Base\Contracts;

use Base\Concretes\BaseQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function paginate(array $conditions = [], int $perPage = 10, array $with = [], array $columns = ['*']): Collection|LengthAwarePaginator;

    public function queryPaginate(BaseQuery $baseQuery, array $conditions = [], int $perPage = 10, array $with = [], array $columns = ['*']): Collection|LengthAwarePaginator;

    public function get(array $conditions = [], array $with = [], array $columns = ['*']): Collection;

    public function queryGet(BaseQuery $baseQuery, array $conditions = [], array $with = [], array $columns = ['*']): Collection;

    public function first(array $conditions = [], array $with = []): Model|static|null;

    public function firstOrFail(array $conditions = [], array $with = []): Model;

    public function updateOrCreate(array $attributes, array $values = []): Model|static;

    public function queryFindOrFail(BaseQuery $baseQuery, int $modelId, bool $unsetWheres = true): Model;

    public function findFromMixed(Model|int|string $model, ?string $key = null): Model;

    public function update(Model $model, array $attributes, ?BaseQuery $baseQuery = null, ?bool $unsetWheres = true): Model;

    public function store(array $attributes, ?BaseQuery $baseQuery = null, ?bool $unsetWheres = true): Model;

    public function getBuilder(): Builder;

    public function findOrFail(int $modelId): Model;

    public function exists(array $conditions = []): bool;

    public function destroy(Model $model): bool;
}
