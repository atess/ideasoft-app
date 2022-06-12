<?php

namespace Base\Concretes;

use Base\Contracts\BaseRepositoryInterface;
use Base\Contracts\BaseServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class BaseService implements BaseServiceInterface
{
    /**
     * Islemin yapilacagi repository dondurmeli
     *
     * @return BaseRepositoryInterface
     */
    abstract public function repository(): BaseRepositoryInterface;

    /**
     * Islemin yapilacagi query dondurulmeli
     *
     * @return BaseQuery
     */
    abstract public function query(): BaseQuery;

    /**
     * Verilen parametrelere gore tum sonuclari dondur
     *
     * @param array $conditions
     * @param int $perPage
     * @param array $with
     * @param array $columns
     * @return Collection|LengthAwarePaginator
     */
    public function paginate(array $conditions = [], int $perPage = 10, array $with = [], array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->repository()->paginate($conditions, $perPage, $with, $columns);
    }

    /**
     * Sayfalama default: true
     * paginate:true gönderilirse sayfalayarak döndürür.
     * paginate:false gönderilirse tüm listeyi döndürür.
     *
     * @param array $conditions
     * @param int $perPage
     * @param array $with
     * @param array $columns
     * @return Collection|LengthAwarePaginator
     */
    public function queryGetOrPaginate(array $conditions = [], int $perPage = 10, array $with = [], array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return request()->input('paginate', true)
            ? $this->repository()->queryPaginate($this->query(), $conditions, $perPage, $with, $columns)
            : $this->repository()->queryGet($this->query(), $conditions, $with, $columns);
    }

    /**
     * Verilen query ve parametrelere gore tum sonuclari dondur
     *
     * @param array $conditions
     * @param array $with
     * @param array $columns
     * @return Collection
     */
    public function queryGet(array $conditions = [], array $with = [], array $columns = ['*']): Collection
    {
        return $this->repository()->queryGet($this->query(), $conditions, $with, $columns);
    }

    /**
     * Verilen query ve parametrelere gore tum sonuclari dondur
     *
     * @param array $conditions
     * @param array $with
     * @param array $columns
     * @return Collection
     */
    public function get(array $conditions = [], array $with = [], array $columns = ['*']): Collection
    {
        return $this->repository()->get($conditions, $with, $columns);
    }

    /**
     * Verilen query ve parametrelere gore sonuclari dondur
     * Sayfalama default: true
     * paginate:true gönderilirse sayfalayarak döndürür.
     * paginate:false gönderilirse tüm listeyi döndürü
     *
     * @param array $conditions
     * @param int $perPage
     * @param array $with
     * @param array $columns
     * @return Collection
     */
    public function getOrPaginate(array $conditions = [], int $perPage = 10, array $with = [], array $columns = ['*']): Collection
    {
        return request()->input('paginate', true)
            ? $this->repository()->paginate($conditions, $perPage, $with, $columns)
            : $this->repository()->get($conditions, $with, $columns);
    }

    /**
     * Verilen perPage parametresine gore sonuclari sayfalayarak dondurur
     *
     * @param array $conditions
     * @param int $perPage
     * @param array $with
     * @param array $columns
     * @return Collection|LengthAwarePaginator
     */
    public function queryPaginate(array $conditions = [], int $perPage = 10, array $with = [], array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->repository()->queryPaginate($this->query(), $conditions, $perPage, $with, $columns);
    }

    /**
     * @param array $conditions
     * @param array $with
     * @return Model|null
     */
    public function first(array $conditions = [], array $with = []): Model|null
    {
        return $this->repository()->first($conditions, $with);
    }

    /**
     * @param array $conditions
     * @param array $with
     * @return Model
     */
    public function firstOrFail(array $conditions = [], array $with = []): Model
    {
        return $this->repository()->firstOrFail($conditions, $with);
    }

    /**
     * @param array $conditions
     * @return bool
     */
    public function exists(array $conditions = []): bool
    {
        return $this->repository()->exists($conditions);
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
        return $this->repository()->updateOrCreate($attributes, $values);
    }

    /**
     * Verilen modeli verilen data ile guncelle
     *
     * @param Model $model
     * @param BaseData $baseData
     * @param bool $unsetWheres
     * @return Model
     */
    public function update(Model $model, BaseData $baseData, bool $unsetWheres = true): Model
    {
        return $this->repository()->update($model, $baseData->onlyFilled()->toArray(), $this->query(), $unsetWheres);
    }

    /**
     * Yeni kayit ekle
     *
     * @param BaseData $baseData
     * @param bool $unsetWheres
     * @return Model
     */
    public function store(BaseData $baseData, bool $unsetWheres = true): Model
    {
        return $this->repository()->store($baseData->onlyFilled()->toArray(), $this->query(), $unsetWheres);
    }

    /**
     * Id degeri gonderilen modeli bul
     *
     * @param int $modelId
     * @return Model
     */
    public function findOrFail(int $modelId): Model
    {
        return $this->repository()->findOrFail($modelId);
    }

    /**
     * Verilen parametreye gore modeli bul
     *
     * @param Model|int|string $model
     * @param string|null $key
     * @return Model
     */
    public function findFromMixed(Model|int|string $model, ?string $key = null): Model
    {
        return $this->repository()->findFromMixed($model, $key);
    }

    /**
     * Verilen model id degerine gore modeli dondur
     *
     * @param int $modelId
     * @param bool $unsetWheres
     * @return Model
     */
    public function queryFindOrFail(int $modelId, bool $unsetWheres = true): Model
    {
        return $this->repository()->queryFindOrFail($this->query(), $modelId, $unsetWheres);
    }

    /**
     * Verilen modeli sil
     *
     * @param Model $model
     * @return bool
     */
    public function destroy(Model $model): bool
    {
        return $this->repository()->destroy($model);
    }
}
