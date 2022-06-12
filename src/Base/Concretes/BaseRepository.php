<?php

namespace Base\Concretes;

use Base\Contracts\BaseRepositoryInterface;
use Domain\Order\Exceptions\OutOfStockException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Throwable;

abstract class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(public Model $model)
    {
    }

    /**
     * Yeni kayit ekle
     *
     * @param array $attributes
     * @param BaseQuery|null $baseQuery
     * @param bool $unsetWheres
     * @return Model
     */
    public function store(array $attributes, ?BaseQuery $baseQuery = null, ?bool $unsetWheres = true): Model
    {
        try {
            DB::beginTransaction();

            $model = $this->getBuilder()->create($attributes);

            if (!is_null($baseQuery)) {
                $model = $baseQuery
                    ->when($unsetWheres, function (Builder $query) {
                        $query->unsetWheres();
                    })
                    ->where($model->getKeyName(), $model->getKey())
                    ->firstOrFail();
            }

            DB::commit();
        } catch (QueryException $queryException) {
            DB::rollBack();

            throw $queryException;
        }

        return $model;
    }

    /**
     * Varsa güncelle yoksa ekle
     *
     * @param array $attributes
     * @param array $values
     * @return Model|static
     */
    public function updateOrCreate(array $attributes, array $values = []): Model|static
    {
        return $this->getBuilder()->updateOrCreate($attributes, $values);
    }

    /**
     * @param array $conditions
     * @param array $with
     * @return Model|null
     */
    public function first(array $conditions = [], array $with = []): Model|null
    {
        return $this->getBuilder()
            ->where($conditions)
            ->with($with)
            ->first();
    }

    /**
     * @param array $conditions
     * @param array $with
     * @return Model
     */
    public function firstOrFail(array $conditions = [], array $with = []): Model
    {
        return $this->getBuilder()
            ->where($conditions)
            ->with($with)
            ->firstOrFail();
    }

    /**
     * Verilen parametreye gore modeli bul
     *
     * @param Model|int|string $model
     * @param string|null $key
     * @return Model
     * @throws OutOfStockException
     */
    public function findFromMixed(Model|int|string $model, ?string $key = null): Model
    {
        if ($model instanceof Model) {
            return $model;
        }

        if (is_numeric($model)) {
            return $this->findOrFail($model);
        }

        if (is_null($key)) {
            throw new OutOfStockException();
        }

        return $this->getBuilder()->where($key, $model)->firstOrFail();
    }

    /**
     * Verilen modeli verilen degerler ile guncelle
     *
     * @param Model $model
     * @param array $attributes
     * @param BaseQuery|null $baseQuery
     * @param bool $unsetWheres
     * @return Model
     */
    public function update(Model $model, array $attributes, ?BaseQuery $baseQuery = null, ?bool $unsetWheres = true): Model
    {
        try {
            DB::beginTransaction();

            $model->update($attributes);

            if (!is_null($baseQuery)) {
                $model = $baseQuery
                    ->when($unsetWheres, function (Builder $query) {
                        $query->unsetWheres();
                    })
                    ->where($model->getKeyName(), $model->getKey())
                    ->firstOrFail();
            } else {
                $model->refresh();
            }

            DB::commit();
        } catch (QueryException $queryException) {
            DB::rollBack();

            throw $queryException;
        }

        return $model;
    }

    /**
     * Verilen parametrelere gore tum sonuclari dondur
     *
     * @param array $conditions
     * @param array $with
     * @param array $columns
     * @return Collection
     */
    public function get(array $conditions = [], array $with = [], array $columns = ['*']): Collection
    {
        return $this
            ->getBuilder()
            ->when(count($conditions), function (Builder $query) use ($conditions) {
                $query->where($conditions);
            })
            ->when(count($with), function (Builder $query) use ($with) {
                $query->with($with);
            })
            ->get();
    }

    /**
     * Verilen query ve parametrelere gore tum sonuclari dondur
     *
     * @param BaseQuery $baseQuery
     * @param array $conditions
     * @param array $with
     * @param array $columns
     * @return Collection
     */
    public function queryGet(BaseQuery $baseQuery, array $conditions = [], array $with = [], array $columns = ['*']): Collection
    {
        return $baseQuery
            ->when(count($conditions), function (Builder $query) use ($conditions) {
                $query->where($conditions);
            })
            ->when(count($with), function (Builder $query) use ($with) {
                $query->where($with);
            })
            ->get($columns);
    }

    /**
     * Verilen parametrelere gore sonuclari sayfalayarak dondur
     *
     * @param array $conditions
     * @param integer $perPage
     * @param array $with
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate(array $conditions = [], int $perPage = 10, array $with = [], array $columns = ['*']): LengthAwarePaginator
    {
        return $this
            ->getBuilder()
            ->when(count($conditions), function (Builder $query) use ($conditions) {
                $query->where($conditions);
            })
            ->when(count($with), function (Builder $query) use ($with) {
                $query->with($with);
            })
            ->paginate($perPage, $columns);
    }

    /**
     * Verilen query ve parametrelere gore sonuclari sayfalayarak dondur
     *
     * @param BaseQuery $baseQuery
     * @param array $conditions
     * @param integer $perPage
     * @param array $with
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function queryPaginate(BaseQuery $baseQuery, array $conditions = [], int $perPage = 10, array $with = [], array $columns = ['*']): LengthAwarePaginator
    {
        return $baseQuery
            ->when(count($conditions), function (Builder $query) use ($conditions) {
                $query->where($conditions);
            })
            ->when(count($with), function (Builder $query) use ($with) {
                $query->with($with);
            })
            ->paginate($perPage, $columns);
    }

    /**
     * Verilen query ve model id degerine gore modeli dondur
     *
     * @param BaseQuery $baseQuery
     * @param int $modelId
     * @param bool $unsetWheres
     * @return Model
     */
    public function queryFindOrFail(BaseQuery $baseQuery, int $modelId, bool $unsetWheres = true): Model
    {
        return $baseQuery
            ->when($unsetWheres, function (Builder $query) {
                $query->unsetWheres();
            })
            ->findOrFail($modelId);
    }

    /**
     * Aktif model eloquent builder
     *
     * @return Builder
     */
    public function getBuilder(): Builder
    {
        return $this->model::query();
    }

    /**
     * Verilen modeli sil
     *
     * @param Model $model
     * @return bool
     * @throws Throwable
     */
    public function destroy(Model $model): bool
    {
        return $model->deleteOrFail();
    }

    /**
     * @param array $conditions
     * @return bool
     */
    public function exists(array $conditions = []): bool
    {
        return $this->getBuilder()
            ->where($conditions)
            ->exists();
    }

    /**
     * Id degeri gonderilen modeli bul
     *
     * @param int $modelId
     * @return Model
     */
    public function findOrFail(int $modelId): Model
    {
        return $this->getBuilder()->findOrFail($modelId);
    }

    /**
     * Translate edilecek sütun listesi
     *
     * @return array
     */
    public function translatables(): array
    {
        return $this->model?->translatable ?? [];
    }
}
