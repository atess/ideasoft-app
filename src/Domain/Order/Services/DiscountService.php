<?php

namespace Domain\Order\Services;

use Base\Concretes\BaseService;
use Domain\Order\Contracts\Repositories\DiscountRepositoryInterface;
use Domain\Order\Contracts\Services\DiscountServiceInterface;
use Domain\Order\Queries\DiscountQuery;

class DiscountService extends BaseService implements DiscountServiceInterface
{
    public function __construct(protected DiscountRepositoryInterface $repository)
    {
    }

    public function repository(): DiscountRepositoryInterface
    {
        return $this->repository;
    }

    public function query(): DiscountQuery
    {
        return new DiscountQuery();
    }
}
