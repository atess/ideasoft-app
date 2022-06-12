<?php

namespace Domain\Order\Repositories\Caches;

use Base\Concretes\BaseCacheDecorator;
use Domain\Order\Contracts\Repositories\DiscountRepositoryInterface;

class DiscountCacheDecorator extends BaseCacheDecorator implements DiscountRepositoryInterface
{
}
