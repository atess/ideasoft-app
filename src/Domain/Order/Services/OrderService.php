<?php

namespace Domain\Order\Services;

use Base\Concretes\BaseService;
use Domain\Order\Contracts\Repositories\OrderRepositoryInterface;
use Domain\Order\Contracts\Services\OrderServiceInterface;
use Domain\Order\Queries\OrderQuery;

class OrderService extends BaseService implements OrderServiceInterface
{
    public function __construct(protected OrderRepositoryInterface $repository)
    {
    }

    public function repository(): OrderRepositoryInterface
    {
        return $this->repository;
    }

    public function query(): OrderQuery
    {
        return new OrderQuery();
    }
}
