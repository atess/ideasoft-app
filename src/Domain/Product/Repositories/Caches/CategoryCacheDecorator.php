<?php

namespace Domain\Product\Repositories\Caches;

use Base\Concretes\BaseCacheDecorator;
use Domain\Product\Contracts\Repositories\CategoryRepositoryInterface;

class CategoryCacheDecorator extends BaseCacheDecorator implements CategoryRepositoryInterface
{
}
