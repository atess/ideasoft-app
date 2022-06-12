<?php

namespace App\Traits\Eloquent;

use Illuminate\Database\Eloquent\Builder;

trait UnsetWheres
{
    public function scopeUnsetWheres($query): Builder
    {
        $queryBuilder = $query->getQuery();
        $queryBuilder->bindings['where'] = [];
        $queryBuilder->wheres = [];
        return $query;
    }
}
