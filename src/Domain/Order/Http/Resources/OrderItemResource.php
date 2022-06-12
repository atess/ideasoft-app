<?php

namespace Domain\Order\Http\Resources;

use Base\Concretes\BaseJsonResource;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $quantity
 * @property float $unit_price
 * @property float $total
 */
class OrderItemResource extends BaseJsonResource
{
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return $this->withDefaults([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'total' => $this->total,
        ]);
    }
}
