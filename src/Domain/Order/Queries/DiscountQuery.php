<?php

namespace Domain\Order\Queries;

use Base\Concretes\BaseQuery;
use Domain\Order\Contracts\Repositories\DiscountRepositoryInterface;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedSort;

class DiscountQuery extends BaseQuery
{
    public function __construct(?Request $request = null)
    {
        $repository = resolve(DiscountRepositoryInterface::class);

        parent::__construct($repository->getBuilder(), $request);

        $this
            ->allowedSorts([
                AllowedSort::field('id'),
            ])
            ->allowedIncludes([])
            ->allowedFilters([]);
    }
}
