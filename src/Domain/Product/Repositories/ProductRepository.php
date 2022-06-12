<?php

namespace Domain\Product\Repositories;

use Base\Concretes\BaseRepository;
use Domain\Product\Contracts\Repositories\ProductRepositoryInterface;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getWhereIn(string $colum, array $values): Collection
    {
        return $this->getBuilder()->whereIn($colum, $values)->get();
    }
}
