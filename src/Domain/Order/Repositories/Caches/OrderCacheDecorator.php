<?php

namespace Domain\Order\Repositories\Caches;

use Base\Concretes\BaseCacheDecorator;
use Domain\Order\Contracts\Repositories\OrderRepositoryInterface;

class OrderCacheDecorator extends BaseCacheDecorator implements OrderRepositoryInterface
{
}
