<?php

namespace Support\Cache;

interface CacheInterface
{
    public function get(string $key);

    public function put(string $key, $value, $minutes = false);

    public function has(string $key);

    public function flush();
}
