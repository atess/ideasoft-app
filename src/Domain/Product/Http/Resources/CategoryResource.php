<?php

namespace Domain\Product\Http\Resources;

use Base\Concretes\BaseJsonResource;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * @property string $name
 * @property int $id
 */
class CategoryResource extends BaseJsonResource
{
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return $this->withDefaults([
            'id' => $this->id,
            'name' => $this->name,
        ]);
    }
}
