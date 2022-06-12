<?php

namespace Domain\Product\Services;

use Base\Concretes\BaseService;
use Domain\Product\Contracts\Repositories\CategoryRepositoryInterface;
use Domain\Product\Contracts\Services\CategoryServiceInterface;
use Domain\Product\Queries\CategoryQuery;

class CategoryService extends BaseService implements CategoryServiceInterface
{
    public function __construct(protected CategoryRepositoryInterface $repository)
    {
    }

    public function repository(): CategoryRepositoryInterface
    {
        return $this->repository;
    }

    public function query(): CategoryQuery
    {
        return new CategoryQuery();
    }
}
