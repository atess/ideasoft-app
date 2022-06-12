<?php

namespace Domain\Product\Contracts\Repositories;

use Base\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function getWhereIn(string $colum, array $values): Collection;
}
