<?php

namespace Domain\Order\Http\Resources;

use Base\Concretes\BaseJsonResource;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * @property int $id
 * @property int $user_id
 * @property float $total
 */
class OrderResource extends BaseJsonResource
{
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return $this->withDefaults([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'total' => $this->total,
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
        ]);
    }
}
