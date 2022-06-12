<?php

namespace Domain\Product\Contracts\Services;

use Base\Contracts\BaseServiceInterface;
use Domain\Product\Contracts\Repositories\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface ProductServiceInterface extends BaseServiceInterface
{
    public function __construct(ProductRepositoryInterface $repository);

    public function getWhereIn(string $colum, array $values): Collection;
}
