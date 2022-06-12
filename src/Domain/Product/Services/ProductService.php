<?php

namespace Domain\Product\Services;

use Base\Concretes\BaseService;
use Domain\Product\Contracts\Repositories\ProductRepositoryInterface;
use Domain\Product\Contracts\Services\ProductServiceInterface;
use Domain\Product\Queries\ProductQuery;
use Illuminate\Database\Eloquent\Collection;

class ProductService extends BaseService implements ProductServiceInterface
{
    public function __construct(protected ProductRepositoryInterface $repository)
    {
    }

    public function repository(): ProductRepositoryInterface
    {
        return $this->repository;
    }

    public function query(): ProductQuery
    {
        return new ProductQuery();
    }

    public function getWhereIn(string $colum, array $values): Collection
    {
        return $this->repository()->getWhereIn($colum, $values);
    }
}
