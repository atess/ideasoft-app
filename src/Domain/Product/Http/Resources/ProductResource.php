<?php

namespace Domain\Product\Http\Resources;

use Base\Concretes\BaseJsonResource;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * @property string $name
 * @property int $category_id
 * @property int $stock
 * @property float $price
 * @property int $id
 */
class ProductResource extends BaseJsonResource
{
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return $this->withDefaults([
            'id' => $this->id,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'stock' => $this->stock,
            'price' => $this->price,
            'category' => CategoryResource::make($this->whenLoaded('category')),
        ]);
    }
}
