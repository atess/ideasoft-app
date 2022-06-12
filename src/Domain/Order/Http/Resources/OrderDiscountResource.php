<?php

namespace Domain\Order\Http\Resources;

use Base\Concretes\BaseJsonResource;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * @property int $order_id
 * @property array $discounts
 * @property float $total_discount
 * @property float $discounted_total
 */
class OrderDiscountResource extends BaseJsonResource
{
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return [
            'order_id' => $this->resource['order_id'],
            'discounts' => $this->resource['discounts'],
            'total_discount' => $this->resource['total_discount'],
            'discounted_total' => $this->resource['discounted_total'],
        ];
    }
}
