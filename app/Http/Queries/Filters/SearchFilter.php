<?php

namespace App\Http\Queries\Filters;

use App\Traits\Queries\FullTextSearchStringFormatter;
use Base\Enums\SearchFilterTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class SearchFilter implements Filter
{
    use FullTextSearchStringFormatter;

    public function __construct(
        protected array                $columns,
        protected SearchFilterTypeEnum $type = SearchFilterTypeEnum::OR_WHERE)
    {
    }

    public function __invoke(
        Builder $query,
                $value,
        string  $property
    )
    {
        $columns = $this->columns;

        $query->where(function (Builder $q) use ($value, $columns) {
            foreach ($columns as $column) {
                if (is_array($value)) {
                    foreach ($value as $item) {
                        $this->addQuery($q, $column, $item);
                    }
                } else {
                    $this->addQuery($q, $column, $value);
                }
            }
        });
    }

    private function like(
        Builder      $builder,
                     $column,
                     $value,
        false|string $relation = false,
        false|string $relationMethod = false,
    )
    {
        $type = $this->type->value;

        if ($relation && $relationMethod) {
            $builder->{$relationMethod}($relation, function (Builder $q) use ($column, $value, $type) {
                $q->where($column, 'like', '%' . $value . '%');
            });
        } else {
            $builder->{$type}($column, 'like', '%' . $value . '%');
        }
    }

    private function fullText(
        Builder      $builder,
                     $column,
                     $value,
        false|string $relation = false,
        false|string $relationMethod = false,
    )
    {
        $value = $this->format($value);
        $type = $this->type->value;

        if ($relation && $relationMethod) {
            $builder->{$relationMethod}($relation, function (Builder $q) use ($column, $value, $type) {
                $q->whereFullText($column, $value, ['mode' => 'boolean']);
            });
        } else {
            $builder->{$type}($column, $value, ['mode' => 'boolean']);
        }
    }

    private function addQuery(Builder $builder, string $column, $value)
    {
        $type = $this->type->value;
        $whereColumn = $column;
        $relationMethod = false;
        $relation = false;

        if (str_contains($column, '.')) {
            $relationMethod = str_contains($type, 'or') ? 'orWhereHas' : 'whereHas';
            $whereArray = explode('.', $column);
            $whereColumn = end($whereArray);
            $relation = implode(
                '.',
                collect($whereArray)->filter(function ($w) use ($whereColumn) {
                    return $w != $whereColumn;
                })->values()->toArray()
            );
        }

        match ($this->type) {
            SearchFilterTypeEnum::WHERE,
            SearchFilterTypeEnum::OR_WHERE => $this->like($builder, $whereColumn, $value, $relation, $relationMethod),

            SearchFilterTypeEnum::WHERE_FULLTEXT,
            SearchFilterTypeEnum::OR_WHERE_FULLTEXT => $this->fullText($builder, $whereColumn, $value, $relation, $relationMethod),
        };
    }
}
