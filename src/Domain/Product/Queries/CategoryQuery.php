<?php

namespace Domain\Product\Queries;

use App\Http\Queries\Filters\SearchFilter;
use Base\Concretes\BaseQuery;
use Domain\Product\Contracts\Repositories\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class CategoryQuery extends BaseQuery
{
    public function __construct(?Request $request = null)
    {
        $repository = resolve(CategoryRepositoryInterface::class);

        parent::__construct($repository->getBuilder(), $request);

        $this
            ->allowedSorts([
                AllowedSort::field('id'),
            ])
            ->allowedIncludes([])
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(['name']))
            ]);
    }
}
