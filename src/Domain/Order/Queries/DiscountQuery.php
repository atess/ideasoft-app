<?php

namespace Domain\Order\Queries;

use Base\Concretes\BaseQuery;
use Domain\Order\Contracts\Repositories\DiscountRepositoryInterface;
use Illuminate\Http\Request;

class DiscountQuery extends BaseQuery
{
    public function __construct(?Request $request = null)
    {
        $repository = resolve(DiscountRepositoryInterface::class);

        parent::__construct($repository->getBuilder(), $request);

        $this
            // ->allowedSorts([])
            // ->allowedIncludes([])
            ->allowedFilters([]);
    }
}
