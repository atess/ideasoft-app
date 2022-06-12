<?php


namespace Base\Concretes;

use Base\Contracts\BaseRepositoryInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;
use Support\Cache\Cache as AppCache;

abstract class BaseCacheDecorator implements BaseRepositoryInterface
{
    protected AppCache $cache;

    public function __construct(protected BaseRepositoryInterface $baseRepository, string $cacheGroup = null)
    {
        $this->cache = new AppCache(Cache::store(), $cacheGroup ?? get_class($this->baseRepository));
    }

    public function getCacheInstance(): AppCache
    {
        return $this->cache;
    }

    /**
     * Sonuç cache de varsa cacheden döndür. Cache de yoksa verileri al cache e yaz ve döndür.
     *
     * @param string $function
     * @param array $args
     * @return LengthAwarePaginator|Collection|Model|mixed
     */
    public function getDataIfExistCache(string $function, array $args): mixed
    {
        $queryString = collect($args)->map(function ($arg) {
            if ($arg instanceof BaseQuery) {
                return $arg->toSql();
            }
            return $arg;
        })->toArray();

        try {
            $cacheKey = md5(
                get_class($this) .
                $function .
                serialize(request()->input()) . serialize(url()->current()) .
                serialize(request()->header('App')) .
                serialize(json_encode($queryString))
            );

            if ($this->cache->has($cacheKey)) {
                return $this->cache->get($cacheKey);
            }

            $cacheData = call_user_func_array([$this->baseRepository, $function], $args);

            $this->cache->put($cacheKey, $cacheData);

            return $cacheData;
        } catch (Exception|InvalidArgumentException $ex) {
            info($ex->getMessage());
            return call_user_func_array([$this->baseRepository, $function], $args);
        }
    }

    /**
     * Cache olmadan döndür.
     *
     * @param string $function
     * @param array $args
     * @return mixed
     */
    public function getDataWithoutCache(string $function, array $args): mixed
    {
        return call_user_func_array([$this->baseRepository, $function], $args);
    }

    /**
     * Cache temizle ve veriyi al
     *
     * @param string $function
     * @param array $args
     * @param bool $flushCache
     * @return mixed
     */
    public function flushCacheAndUpdateData(
        string $function,
        array  $args,
        bool   $flushCache = true): mixed
    {
        if ($flushCache) {
            $this->cache->flush();
        }

        return call_user_func_array([$this->baseRepository, $function], $args);
    }

    public function paginate(
        array $conditions = [],
        int   $perPage = 10,
        array $with = [],
        array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function queryPaginate(BaseQuery $baseQuery, array $conditions = [], int $perPage = 10, array $with = [], array $columns = ['*']): Collection|LengthAwarePaginator
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function get(array $conditions = [], array $with = [], array $columns = ['*']): Collection
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function queryGet(BaseQuery $baseQuery, array $conditions = [], array $with = [], array $columns = ['*']): Collection
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function first(array $conditions = [], array $with = []): Model|null
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function firstOrFail(array $conditions = [], array $with = []): Model
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function exists(array $conditions = []): bool
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function updateOrCreate(array $attributes, array $values = []): Model|static
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function findOrFail(int $modelId): Model
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function queryFindOrFail(BaseQuery $baseQuery, int $modelId, bool $unsetWheres = true): Model
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function findFromMixed(Model|int|string $model, ?string $key = null): Model
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    public function update(Model $model, array $attributes, ?BaseQuery $baseQuery = null, ?bool $unsetWheres = true): Model
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function store(array $attributes, ?BaseQuery $baseQuery = null, ?bool $unsetWheres = true): Model
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function destroy(Model $model): bool
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    public function getBuilder(): Builder
    {
        return $this->getDataWithoutCache(__FUNCTION__, func_get_args());
    }

    public function translatables(): array
    {
        return $this->getDataWithoutCache(__FUNCTION__, func_get_args());
    }
}
