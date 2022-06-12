<?php

namespace Domain\Product\Repositories\Caches;

use Base\Concretes\BaseCacheDecorator;
use Domain\Product\Contracts\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProductCacheDecorator extends BaseCacheDecorator implements ProductRepositoryInterface
{
    public function getWhereIn(string $colum, array $values): Collection
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
