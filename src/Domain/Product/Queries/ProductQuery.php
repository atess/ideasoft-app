<?php

namespace Domain\Product\Queries;

use App\Http\Queries\Filters\SearchFilter;
use Base\Concretes\BaseQuery;
use Domain\Product\Contracts\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;

class ProductQuery extends BaseQuery
{
    public function __construct(?Request $request = null)
    {
        $repository = resolve(ProductRepositoryInterface::class);

        parent::__construct($repository->getBuilder(), $request);

        $this
            ->allowedSorts([
                AllowedSort::field('id'),
            ])
            ->allowedIncludes([
                AllowedInclude::relationship('category')
            ])
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(['name', 'category.name']))
            ]);
    }
}
