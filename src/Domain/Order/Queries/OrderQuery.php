<?php

namespace Domain\Order\Queries;

use Base\Concretes\BaseQuery;
use Domain\Order\Contracts\Repositories\OrderRepositoryInterface;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class OrderQuery extends BaseQuery
{
    public function __construct(?Request $request = null)
    {
        $repository = resolve(OrderRepositoryInterface::class);

        parent::__construct($repository->getBuilder(), $request);

        $this
            ->allowedSorts([
                AllowedSort::field('id'),
            ])
            ->allowedIncludes([
                AllowedInclude::relationship('user')
            ])
            ->allowedFilters([]);
    }
}
