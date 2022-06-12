<?php

namespace Base\Concretes;

use Domain\User\Http\Resources\UserResource;
use Domain\User\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilderRequest;

/**
 * @property ?int $created_by
 * @property ?int $updated_by
 * @property ?int $deleted_by
 * @property ?User $createdBy
 * @property ?User $updatedBy
 * @property ?User $deletedBy
 * @property ?string $updated_at
 * @property ?string $created_at
 * @property ?string $deleted_at
 * @property mixed $apps
 */
class BaseJsonResource extends JsonResource
{
    public function withDefaults(array $response): array
    {
        return [...$response, ...$this->defaults()];
    }

    public function defaults(): array
    {
        return [
            'created_at' => $this->when($this->timestampCase(), $this->created_at),
            'updated_at' => $this->when($this->timestampCase(), $this->updated_at),
            'deleted_at' => $this->when($this->deletedAtCase(), $this->deleted_at),

            'created_by' => $this->when($this->createdByCase(), $this->created_by),
            'updated_by' => $this->when($this->updatedByCase(), $this->updated_by),
            'deleted_by' => $this->when($this->deletedByCase(), $this->deleted_by),

            'createdBy' => $this->when($this->createdByRelationCase(), function () {
                return UserResource::make($this->resource->createdBy);
            }),
            'updatedBy' => $this->when($this->updatedByRelationCase(), function () {
                return UserResource::make($this->resource->updatedBy);
            }),
            'deletedBy' => $this->when($this->deletedByRelationCase(), function () {
                return UserResource::make($this->resource->deletedBy);
            }),
        ];
    }

    protected function hasInclude(string $key): bool
    {
        if (request()->filled('include')) {
            return in_array($key, explode(QueryBuilderRequest::getIncludesArrayValueDelimiter(), request()->input('include')));
        }

        return false;
    }

    protected function createdByRelationCase(): bool
    {
        return $this->hasInclude('createdBy') && method_exists($this->resource, 'createdBy');
    }

    protected function updatedByRelationCase(): bool
    {
        return $this->hasInclude('updatedBy') && method_exists($this->resource, 'updatedBy');
    }

    protected function deletedByRelationCase(): bool
    {
        return $this->hasInclude('deletedBy') && method_exists($this->resource, 'deletedBy');
    }

    protected function createdByCase(): bool
    {
        return method_exists($this->resource, 'createdBy');
    }

    protected function updatedByCase(): bool
    {
        return method_exists($this->resource, 'updatedBy');
    }

    protected function deletedByCase(): bool
    {
        return method_exists($this->resource, 'deletedBy');
    }

    protected function deletedAtCase(): bool
    {
        return method_exists($this->resource, 'deletedBy');
    }

    protected function timestampCase(): bool
    {
        return $this->resource->timestamps;
    }
}
