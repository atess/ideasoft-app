<?php

namespace Domain\Product\Contracts\Services;

use Base\Contracts\BaseServiceInterface;
use Domain\Product\Contracts\Repositories\CategoryRepositoryInterface;

interface CategoryServiceInterface extends BaseServiceInterface
{
    public function __construct(CategoryRepositoryInterface $repository);
}
