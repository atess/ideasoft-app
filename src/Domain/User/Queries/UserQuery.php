<?php

namespace Domain\User\Queries;

use App\Http\Queries\Filters\SearchFilter;
use Base\Concretes\BaseQuery;
use Domain\User\Http\Requests\User\IndexUserRequest;
use Domain\User\Repositories\Contracts\UserRepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class UserQuery extends BaseQuery
{
    public function __construct(?IndexUserRequest $indexUserRequest = null)
    {
        $repository = resolve(UserRepositoryInterface::class);

        parent::__construct($repository->getBuilder(), $indexUserRequest);

        $this
            ->allowedIncludes([])
            ->allowedSorts([
                AllowedSort::field('id'),
                AllowedSort::field('name'),
                AllowedSort::field('email'),
            ])
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(['name', 'email']))
            ]);
    }
}
