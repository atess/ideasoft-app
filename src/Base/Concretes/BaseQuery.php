<?php

namespace Base\Concretes;

use App\Traits\Queries\DefaultQueries;
use Spatie\QueryBuilder\QueryBuilder;

class BaseQuery extends QueryBuilder
{
    use DefaultQueries;
}
