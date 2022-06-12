<?php

namespace Domain\Order\Contracts\Services;

use Base\Contracts\BaseServiceInterface;
use Domain\Order\Contracts\Repositories\OrderRepositoryInterface;

interface OrderServiceInterface extends BaseServiceInterface
{
    public function __construct(OrderRepositoryInterface $repository);
}
