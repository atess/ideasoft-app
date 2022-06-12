<?php

namespace Support\Cache;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Cache implements CacheInterface
{
    public function __construct(protected Repository $cache,
                                protected string $cacheGroup,
                                protected array $config = [])
    {
        $this->config = !empty($this->config) ? $config : [
            'cache_time'  => 60, // minute
        ];
    }

    public function get($key): Collection|LengthAwarePaginator|Model
    {
        return $this->cache->tags([
            $this->cacheGroup
        ])->get($this->generateCacheKey($key));
    }

    public function generateCacheKey(string $key): string
    {
        return md5($this->cacheGroup) . $key;
    }

    public function put(string $key, mixed $value, $minutes = false): bool
    {
        if (!$minutes) {
            $minutes = $this->config['cache_time'];
        }

        $this->cache->tags([
            $this->cacheGroup,
        ])->put(
            $this->generateCacheKey($key),
            $value,
            $minutes
        );

        return true;
    }

    public function has($key): bool
    {
        return $this->cache->tags([
            $this->cacheGroup,
        ])->has(
            $this->generateCacheKey($key)
        );
    }

    public function flush(): bool
    {
        return $this->cache->tags([
            $this->cacheGroup,
        ])->flush();
    }
}
